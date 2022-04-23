<?php
include "../config/connexion.php";
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /monoshop');
}
$req = $access->prepare("SELECT * FROM users where role = 'ROLE_USER'");
$req->execute();
$users = $req->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body>



    <header>
        <div id="menu-bar" class="fas fa-bars"></div>

        <a href="#" class="logo nike">nike</a>
        <nav class="navbar">
            <a href="dashboard.php">home</a>
            <a href="produits.php">Produits</a>
            <a href="users.php">Utilisateurs</a>
        </nav>

        <div class="icons d-flex align-items-center">
            <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="?logout" class="fa fa-sign-out"></a>';
            } else {
                echo '<a href="login.php" class="fas fa-user"></a>';
            }
            ?>
            <a href="#"><?= isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '' ?></a>
            <?php
            if (isset($_SESSION['id'])) {
                echo '<img src="../' . $_SESSION['avatar'] . '" style="width:50px;height:50px;border-radius:50%">';
            }
            ?>
        </div>
    </header>
    <section class="products" id="products" style="margin-top: 10%;">
        <h1 class="heading">Tout les Utilisateurs <span>Inscrit</span></h1>
        <div>
            <table id="datatable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= $user->id ?></td>
                            <td><img src="../<?= $user->avatar ?>" width="75" height="75" style="border-radius: 50%;"></td>
                            <td><?= $user->first_name ?></td>
                            <td><?= $user->last_name ?></td>
                            <td><?= $user->email ?></td>
                            <td>
                                <?php if ($user->status == 1) { ?>
                                    <div class="badge badge-success">Active</div>
                                <?php } else if ($user->status == 0) { ?>
                                    <div class="badge badge-danger">Bloqué</div>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($user->status == 1) { ?>
                                    <button type="button" class="btn btn-warning btn-sm disable" data-id="<?= $user->id ?>">Disable</button>
                                <?php } else if ($user->status == 0) { ?>
                                    <button type="button" class="btn btn-success btn-sm enable" data-id="<?= $user->id ?>">Enable</button>
                                <?php } ?>
                                <button type="button" class="btn btn-danger btn-sm delete" data-id="<?= $user->id ?>">Supprimé</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </section>
    <script src="./main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        var table = $('#datatable').DataTable();
        $(document).on('click', '.delete', function() {
            let btn = $(this);
            $.ajax({
                url: "../ajax_functions.php",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action: "deleteUser",
                    user_id: $(this).data('id'),
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                        })
                        table
                            .row(btn.closest('tr'))
                            .remove()
                            .draw();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: data.message,
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Un erreur est survenue, SVP réessayer plus tard !!",
                    })
                }
            })
        });
        $(document).on('click', '.enable', function() {
            let btn = $(this);
            $.ajax({
                url: "../ajax_functions.php",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action: "enableUser",
                    user_id: $(this).data('id'),
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                        })
                        
                        let row = table.row(btn.closest('tr')).data();
                        row[5] = '<div class="badge badge-success">Active</div>';
                        row[6] = `<button type="button" class="btn btn-warning btn-sm disable" data-id="${row[0]}">Disable</button><button type="button" class="btn btn-danger btn-sm delete" data-id="${row[0]}">Supprimé</button>`;
                        table.row(btn.closest('tr')).data(row).draw();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: data.message,
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Un erreur est survenue, SVP réessayer plus tard !!",
                    })
                }
            })
        });
        $(document).on('click', '.disable', function() {
            let btn = $(this);
            $.ajax({
                url: "../ajax_functions.php",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action: "disableUser",
                    user_id: $(this).data('id'),
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                        })
                        let row = table
                            .row(btn.closest('tr'))
                            .data();
                            row[5] = '<div class="badge badge-danger">Bloqué</div>';
                            row[6] = `<button type="button" class="btn btn-warning btn-sm enable" data-id="${row[0]}">Enable</button><button type="button" class="btn btn-danger btn-sm delete" data-id="${row[0]}">Supprimé</button>`;
                        table
                            .row(btn.closest('tr'))
                            .data(row)
                            .draw();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: data.message,
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Un erreur est survenue, SVP réessayer plus tard !!",
                    })
                }
            })
        });
    </script>
</body>

</html>