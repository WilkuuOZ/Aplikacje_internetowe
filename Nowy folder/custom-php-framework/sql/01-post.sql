create table if not exists post
(
    id      integer not null
        constraint post_pk
            primary key autoincrement,
    subject text not null,
    content text not null
);
CREATE TABLE IF NOT EXISTS book (
                                    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                                    title TEXT,
                                    author TEXT,
                                    isbn TEXT
);
