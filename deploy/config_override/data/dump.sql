-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Лип 09 2016 р., 19:29
-- Версія сервера: 5.7.12-0ubuntu1.1
-- Версія PHP: 5.6.23-2+deb.sury.org~xenial+1

--
-- База даних: `bookstore`
--

DROP DATABASE IF EXISTS `bookstore`;
CREATE DATABASE `bookstore`;

-- 
-- Вибір щойно створеної бази даних як поточної
--
USE `bookstore`;

-- --------------------------------------------------------

--
-- Структура таблиці `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  primary key (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `genres`
--
CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255),
  `published_year` int,
  primary key (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблиці `books_authors`
--
CREATE TABLE `books_authors` (
    `id` int NOT NULL,
    `book_id` int NOT NULL,
    `author_id` int NOT NULL,
    primary key (`id`),
    foreign key (`book_id`) references `books`(`id`),
    foreign key (`author_id`) references `authors`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `books_genres`
--
CREATE TABLE `books_genres` (
    `id` int NOT NULL,
    `book_id` int NOT NULL,
    `genre_id` int NOT NULL,
    primary key (`id`),
    foreign key (`book_id`) references `books`(`id`),
    foreign key (`genre_id`) references `genres`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--