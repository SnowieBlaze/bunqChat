CREATE TABLE users (
                       id INTEGER PRIMARY KEY AUTOINCREMENT,
                       username TEXT NOT NULL UNIQUE
);

CREATE TABLE groups (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        creator_id INTEGER NOT NULL,
                        name TEXT NOT NULL UNIQUE,
                        FOREIGN KEY (creator_id) REFERENCES users(id)
);

CREATE TABLE group_users (
                             user_id INTEGER,
                             group_id INTEGER,
                             PRIMARY KEY (user_id, group_id),
                             FOREIGN KEY (user_id) REFERENCES users(id),
                             FOREIGN KEY (group_id) REFERENCES groups(id)
);

CREATE TABLE messages (
                          id INTEGER PRIMARY KEY AUTOINCREMENT,
                          content TEXT NOT NULL,
                          author_id INTEGER NOT NULL,
                          group_id INTEGER NOT NULL,
                          timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (author_id) REFERENCES users(id),
                          FOREIGN KEY (group_id) REFERENCES groups(id)
);
