create database supermetrics;
use supermetrics;

CREATE TABLE posts
(
    id INTEGER AUTO_INCREMENT,
    slug VARCHAR(255) UNIQUE NOT NULL,
    user_name VARCHAR(255),
    user_slug VARCHAR(255) NOT NULL,
    message TEXT,
    type VARCHAR(255) NOT NULL,
    created_at DATETIME,
    PRIMARY KEY (id)
) COMMENT='fetched posts';