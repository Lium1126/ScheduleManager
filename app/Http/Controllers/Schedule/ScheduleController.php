<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Auth;

class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all shedules data
     *
     * @return view home with $msg, $schedules
     */
    public function all_schedules_get(Request $request)
    {
        if (isset($request['q']) and $request['q'] != "") {
            $schedules = Schedule::where('user_id', AUTH::user()->id)
                ->where('begin', 'like', '%' . $request['q'] . '%')
                ->orWhere('begin', 'like', '%' . $request['q'] . '%')
                ->orWhere('end', 'like', '%' . $request['q'] . '%')
                ->orWhere('place', 'like', '%' . $request['q'] . '%')
                ->orWhere('content', 'like', '%' . $request['q'] . '%')
                ->orderByRaw('begin')
                ->get();
        } else {
            $schedules = Schedule::where('user_id', AUTH::user()->id)->orderByRaw('begin')->get();
        }

        return view('home', [
            'msg' => "",
            'schedules' => $schedules
        ]);
    }

    /**
     * Send schedule data to add confirm
     *
     * @return if not err: view add confirm with $schedule
     *            have an err: view home with $msg
     */
    public function confirm_add_schedule(Request $request)
    {
        $msg = "";
        $beginTime = sprintf("%s %s:%s:00", $request["begin-date"], $request["begin-hour"], $request["begin-minute"]);
        $endTime = sprintf("%s %s:%s:00", $request["end-date"], $request["end-hour"], $request["end-minute"]);

        /* form data convert */
        $schedule = [
            "begin" => $beginTime,
            "end" => $endTime,
            "place" => $request["place"],
            "content" => $request["content"],
        ];

        /* assertion check */
        if (!strlen($request["begin-date"])) $msg .= "Begin time";
        if (!strlen($request["end-date"])) {
            if (strlen($msg)) $msg .= ", ";
            $msg .= "End time";
        }
        if (!strlen($request["place"])) {
            if (strlen($msg)) $msg .= ", ";
            $msg .= "Place";
        }
        if (!strlen($request["content"])) {
            if (strlen($msg)) $msg .= ", ";
            $msg .= "Content";
        }

        if (strlen($msg)) {
            $msg = "Required! : " . $msg;
        }

        /* time check */
        if ($beginTime > $endTime) {
            if (strlen($msg)) $msg .= "\n";
            $msg .= "Error! : End time must be later than Begin time";
        }

        if (strlen($msg)) return view('home', ['msg' => $msg, 'schedules' => Schedule::where('user_id', AUTH::user()->id)->orderByRaw('begin')->get()]);

        return view('addconfirm', ['schedule' => $schedule]);
    }

    /**
     * Send schedule data to remove confirm
     *
     * @return view remove confirm with $schedule
     */
    public function confirm_remove_schedule(Request $request)
    {
        $schedule = [
            "id" => $request["id"],
            "begin" => $request["begin"],
            "end" => $request["end"],
            "place" => $request["place"],
            "content" => $request["content"],
        ];

        return view('removeconfirm', ['schedule' => $schedule]);
    }

    /**
     * Send schedule data to update
     *
     * @return view update with $schedule and $msg(empty)
     */
    public function show_update_form(Request $request)
    {
        $schedule = [
            "id" => $request["id"],
            "begin" => $request["begin"],
            "end" => $request["end"],
            "place" => $request["place"],
            "content" => $request["content"],
        ];

        return view('update', ['schedule' => $schedule, 'msg' => ""]);
    }

    /**
     * Send schedule data to update confirm
     *
     * @return if not err: view update confirm with $schedule
     *            have an err: view update with $msg and $schedule
     */
    public function confirm_update_schedule(Request $request)
    {
        $msg = "";
        $beginTime = sprintf("%s %s:%s:00", $request["begin-date"], $request["begin-hour"], $request["begin-minute"]);
        $endTime = sprintf("%s %s:%s:00", $request["end-date"], $request["end-hour"], $request["end-minute"]);

        /* form data convert */
        $schedule = [
            "id" => $request["id"],
            "begin" => $beginTime,
            "end" => $endTime,
            "place" => $request["place"],
            "content" => $request["content"],
        ];

        /* assertion check */
        if (!strlen($request["begin-date"])) $msg .= "Begin time";
        if (!strlen($request["end-date"])) {
            if (strlen($msg)) $msg .= ", ";
            $msg .= "End time";
        }
        if (!strlen($request["place"])) {
            if (strlen($msg)) $msg .= ", ";
            $msg .= "Place";
        }
        if (!strlen($request["content"])) {
            if (strlen($msg)) $msg .= ", ";
            $msg .= "Content";
        }

        if (strlen($msg)) {
            $msg = "Required! : " . $msg;
        }

        /* time check */
        if ($beginTime > $endTime) {
            if (strlen($msg)) $msg .= "\n";
            $msg .= "Error! : End time must be later than Begin time";
        }

        if (strlen($msg)) return view('update', ['msg' => $msg, 'schedule' => $schedule]);

        return view('updateconfirm', ['schedule' => $schedule]);
    }

    /**
     * Run SQL query and send message to result
     *
     * @return if set regulation query: view done with $schedule, $result(err flag) and $msg
     *         else: view home
     */
    public function dojob(Request $request)
    {
        $schedule = [
            "id" => strlen($request["id"]) ? $request["id"] : "",
            "begin" => $request["begin"],
            "end" => $request["end"],
            "place" => $request["place"],
            "content" => $request["content"],
        ];

        if ($request['jobtype'] == "insert") {
            try {
                Schedule::insert(
                    ['begin' => $schedule['begin'], 'end' => $schedule['end'], 'place' => $schedule['place'], 'content' => $schedule['content'], 'user_id' => Auth::user()->id]
                );
                return view('done', ['schedule' => $schedule, 'result' => true, 'msg' => "Added successfully!"]);
            } catch (Exception $e) {
                return view('done', ['schedule' => $schedule, 'result' => false, 'msg' => $e->getMessage()]);
            }
        } else if ($request['jobtype'] == "remove") {
            try {
                Schedule::where('id', $schedule['id'])->delete();
                return view('done', ['schedule' => $schedule, 'result' => true, 'msg' => 'Removed successfully!']);
            } catch (Exception $e) {
                return view('done', ['schedule' => $schedule, 'result' => false, 'msg' => $e->getMessage()]);
            }
        } else if ($request['jobtype'] == "update") {
            try {
                Schedule::where('id', $schedule['id'])->update(['begin' => $schedule['begin'], 'end' => $schedule['end'], 'place' => $schedule['place'], 'content' => $schedule['content']]);
                return view('done', ['schedule' => $schedule, 'result' => true, 'msg' => 'Updated successfully!']);
            } catch (Exception $e) {
                return view('done', ['schedule' => $schedule, 'result' => false, 'msg' => $e->getMessage()]);
            }
        } else {
            return view('home', ['msg' => "Incorrect query!", 'schedules' => Schedule::where('user_id', AUTH::user()->id)->orderByRaw('begin')->get()]);
        }
    }

    /**
     * Send schedule data to weekly
     *
     * @return view weekly with $schedules, $sun and $sat
     */
    public function weekly_schedule(Request $request)
    {
        return view('weekly', [
            'schedules' => Schedule::where('user_id', Auth::user()->id)->whereBetween('begin', [$request['sun-date'] . " 00:00:00", $request['sat-date'] . " 23:59:59"])->orderByRaw('begin')->get(),
            'sun' => $request['sun-date'],
            'sat' => $request['sat-date']
        ]);
    }

    /**
     * Send schedule data to monthly
     *
     * @return view monthly with $schedules, $year and $month
     */
    public function monthly_schedule(Request $request)
    {
        return view('monthly', [
            'schedules' => Schedule::where('user_id', Auth::user()->id)->where('begin', 'like', $request['year-and-month'] . "%")->get(),
            'year' => substr($request['year-and-month'], 0, 4),
            'month' => substr($request['year-and-month'], 5, 2)
        ]);
    }
}
