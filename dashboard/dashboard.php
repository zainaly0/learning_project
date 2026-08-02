<?php
require_once __DIR__ . "/../middleware/authMiddleware.php"; 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: arial;
        }

        body {
            background: #f4f6f9;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #1e293b;
            color: #fff;
            padding: 25px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            padding: 12px;
            color: #fff;
            text-decoration: none;
            display: block;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a:active {
            background: #2563eb;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        header {
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            background: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
            color: #333;
        }

        header .user {
            font-size: 16px;
        }

        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-btn {
            background-color: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .user-btn strong{
            color: #fff;
        }

        .dropdown{
            display: none;
            position: absolute;
            right: 0;
            top: 38px;
            background: #fff;
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            overflow: hidden;
            z-index: 1000;
        }

        .dropdown a{
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: #333;
            transition: 0.3s;
        }

        .dropdown a:hover{
            background-color: #f1f1f1;
        }

        .user-menu:hover .dropdown{
            display: block;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 30px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .card h3 {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }

        .content {
            padding: 0 30px 30px;
        }

        .table-box {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08s);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2563eb;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <aside class="sidebar">
            <h2>My Panel</h2>

            <ul>
                <li> <a href='<?= url("/dashboard/dashboard.php"); ?>' class="link">Dashboard</a> </li>
                <li> <a href='<?= url("/dashboard/profile.php") ?>' class="link">Profile</a> </li>
            </ul>
        </aside>

        <div class="main">
            <header>
                <h2>Dashboard</h2>
                <!-- <div>welcome, <strong> <?= $_SESSION['name']; ?> </strong></div> -->
                <div class="user-menu">
                    <button class="user-btn">
                        welcome, <strong> <?= $_SESSION['name']; ?> </strong>
                    </button>

                    <div class="dropdown">
                        <a href="<?=  url("/dashboard/profile.php");  ?>">Profile</a>
                        <a href="../auth/logout.php">Logout</a>
                    </div>
                </div>
            </header>

            <section class="cards">
                <div class="card">
                    <h3>Total Users</h3>
                    <p>12</p>
                </div>
                <div class="card">
                    <h3>Pending Orders</h3>
                    <p>3</p>
                </div>
                <div class="card">
                    <h3>complete</h3>
                    <p>9</p>
                </div>
                <div class="card">
                    <h3>Account status</h3>
                    <p style="font-size:20px; color:green;">Active</p>
                </div>
            </section>

            <div class="content">
                <div class="table-box">
                    <h3>Recent Activity</h3>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Activity</th>
                            <th>Date</th>
                        </tr>
                        <tr>
                            <td>#101</td>
                            <td>Logged into account</td>
                            <td>Today</td>
                        </tr>

                        <tr>
                            <td>#102</td>
                            <td>Updated Profile</td>
                            <td>Yesterday</td>
                        </tr>

                        <tr>
                            <td>#103</td>
                            <td>Placed an Order</td>
                            <td>2 Days Ago</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>