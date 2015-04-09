<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 11/16/13
 * Time: 10:27 AM
 */
include 'functions.php';

createTable('users',
            'user VARCHAR(16) PRIMARY KEY,
            pass VARCHAR(16),
            userType INT UNSIGNED,
            fName VARCHAR(20),
            lName VARCHAR(20),
            mInitial CHAR(1)');
$query = "INSERT INTO users VALUES ('csheen', 'password', '0', 'Charlie', 'Sheen', 'I')";
queryMysql($query);
$query = "INSERT INTO users VALUES ('employee', 'cr21589', '1', 'Charles', 'Riley', 'E')";
queryMysql($query);
$query = "INSERT INTO users VALUES ('manager', 'rs21589', '2', 'Richard', 'Saunders', 'A')";
queryMysql($query);

createTable('orders',
            'orderID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            orderDate INT UNSIGNED,
            shipDate INT UNSIGNED,
            street VARCHAR(50),
            city VARCHAR(25),
            zip INT UNSIGNED,
            state CHAR(2)');


createTable('place',
            'user VARCHAR(16),
            orderID INT UNSIGNED,
            FOREIGN KEY (user) REFERENCES users(user),
            FOREIGN KEY (orderID) REFERENCES orders(orderID),
            PRIMARY KEY(user, orderID)');


createTable('inventory',
            'toyGameID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(16),
            unitCost DECIMAL(10,2),
            description VARCHAR(100),
            imageAddress VARCHAR(25),
            stockCount INT UNSIGNED,
            unitWeight INT UNSIGNED,
            percentOff DECIMAL(10,2)');
$query = "INSERT INTO inventory VALUES ('null', 'Kitty', '1.00', 'A very cute kitten that your kids would love to have.', 'images/kitty.jpg', '400', '2', '1.00')";
queryMysql($query);
$query = "INSERT INTO inventory VALUES ('null', 'Bunny', '2.00', 'A beautiful bunny that is great for cuddling. He has the softest fur.', 'images/bunny.jpg', '300', '1', '.90')";
queryMysql($query);
$query = "INSERT INTO inventory VALUES ('null', 'Tiger', '3.00', 'This tiger is very soft and cuddly. Children of all ages will love him.', 'images/tiger.jpg', '500', '3', '.95')";
queryMysql($query);
$query = "INSERT INTO inventory VALUES ('null', 'Seal', '2.50', 'This sweet seal loves to be held. Kids will never want to let go of him.', 'images/seal.jpg', '250', '2', '1.00')";
queryMysql($query);
$query = "INSERT INTO inventory VALUES ('null', 'Yahtzee', '20.00', 'A classic board game we all know and love. YAHTZEE!', 'images/yahtzee.jpg', '150', '5', '1.00')";
queryMysql($query);

createTable('contains',
            'orderID INT UNSIGNED,
            toyGameID INT UNSIGNED,
            quantity INT UNSIGNED,
            FOREIGN KEY (orderID) REFERENCES orders(orderID),
            FOREIGN KEY (toyGameID) REFERENCES inventory(toyGameID),
            PRIMARY KEY(orderID, toyGameID)');


?>