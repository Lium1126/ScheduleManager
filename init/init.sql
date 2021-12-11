DROP TABLE IF EXISTS schedules;

CREATE TABLE schedules (
    id          int(11)         NOT NULL AUTO_INCREMENT,
    begin       datetime        NOT NULL,
    end         datetime        NOT NULL,
    place       varchar(256)    NOT NULL,
    content     text            NOT NULL,
    user_id     bigint(20)      NOT NULL,
    updated_at  datetime,
    PRIMARY KEY (id)
);

ALTER TABLE schedules ADD INDEX begin_index (id, begin);
ALTER TABLE schedules ADD INDEX user_index (id, user_id);

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-13 15:30:00', '2021-11-13 16:00:00', '自宅', '宿題', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-14 10:00:00', '2021-11-14 12:00:00', 'イオン', '買い物', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-22 15:30:00', '2021-11-14 17:30:00', 'オンライン', '座談会', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-25 09:00:00', '2021-11-25 12:10:00', '大学', '授業', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-25 19:00:00', '2021-11-25 20:00:00', 'オンライン', '就活', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-28 10:00:00', '2021-11-28 20:00:00', 'オンライン', 'インターン', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2022-01-01 00:00:00', '2022-01-01 23:59:00', '自宅', '正月', '1', now());

INSERT INTO schedules (begin, end, place, content, user_id, updated_at)
VALUES ('2021-11-13 12:30:00', '2021-11-13 13:00:00', 'ららぽーと東郷', 'ランチ', '2', now());
