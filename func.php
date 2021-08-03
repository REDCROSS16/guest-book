<?php

const HOST = 'localhost';
const USERNAME = 'root';
const PASSWORD = 'root';
const DBNAME = 'test_16';
const GUEST = 'guestbook';


function connect() {
    $db = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    return $db;
}


function pagination ($notesOnPage) {
    # подключение к БД

    $db = connect();

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    # пагинация
    $countQuery = "SELECT COUNT(*) as count FROM `guestbook`";
    $count = $db->query($countQuery);

    $pages = ceil($count->fetch_assoc()['count'] / $notesOnPage);

    $result = '<nav>';
    $result .= '<ul class="pagination">';

    # создание страниц пагинации
    if ($page > 1) {
        $previousPage = $page - 1;
        $result .= "<li><a href='?page=$previousPage' style='color:darkseagreen'><</a></li>";
    } else {
        $result .= "<li class='disabled'><a href='#' disabled><</a></li>";
    }

    for ($i=1; $i <= $pages; $i++) {
        if ($page == $i) {
            $result .= '<li class="active"><a href="?page=' . $i . '" >' . $i . '</a></li> ';
        } else {
            $result .= '<li><a href="?page=' . $i . '">' . $i . '</a></li> ';
        }
    }

    if ($page < $pages) {
        $nextPage = $page + 1;
        $result .= "<li><a href='?page=$nextPage'>></a></li>";
    } else {
        $result .= "<li class='disabled'><a href='#' disabled>></a></li>";
    }
    $result .= '</ul></nav>';
    return $result;
}

/**
 *  показывает информацию с БД
*/
function showData() {
    $db = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

    $notesOnPage = 5;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

//    $countQuery = "SELECT COUNT(*) as count FROM guestbook";
//    $count = $db->query($countQuery);
//
//    $dir = ceil($count->fetch_assoc()['count'] / $notesOnPage);
    $from = ($page - 1 ) * $notesOnPage;

    $query = "SELECT * FROM guestbook LIMIT $from, $notesOnPage";
    $data = $db->query($query);

    $result = '';

    foreach ($data as $item ) {
        $result .= '<div style="border: 1px dashed black">';
        $result .= '<p>';
        $result .= "<span class='date'>" . $item['date'] . "</span>";
        $result .= " <span class='date' style='color:cornflowerblue'>" . $item['user'] . "</span>";
        $result .= '</p>';
        $result .= '<p style="font-style: italic">' . $item['message'] . '</p>';
        $result .= '<button class="btn btn-danger" ><a href="?del='. $item['id'] .'"' . ' style="color:white">Delete</a></button></div>';
    }

    return $result;
}


function addMessage () {
    if (isset($_REQUEST["submit"])) {
        $db = connect();
        $name = $_REQUEST['name'];
        $message = $_REQUEST['message'];
        $date = date('Y-M-D : H:i:s');

        $query = "INSERT INTO guestbook (user, message, date) VALUES ('$name', '$message', '$date')";
        $res = $db->query($query);
        if ($res) {
            return "<div class='info alert alert-info'>Запись успешно сохранена!</div>";
        } else {
            return 'ОШИБКА!!!';
        }
    }
}

function deleteMessage() {

    if (isset($_GET['del'])) {
        $db = connect();
        $id = $_GET['del'];
        $query = "DELETE FROM guestbook WHERE id = $id";
        try {
            $db->query($query);
            var_dump('Сообщение удалено!');
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
    return true;
}