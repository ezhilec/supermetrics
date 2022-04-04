create database supermetrics;
use supermetrics;

CREATE TABLE posts
(
    slug VARCHAR(255) NOT NULL,
    user_name VARCHAR(255),
    user_slug VARCHAR(255) NOT NULL,
    message TEXT,
    type VARCHAR(255) NOT NULL,
    created_at DATETIME,
    PRIMARY KEY (slug),
    INDEX (user_slug)
) COMMENT='fetched posts';