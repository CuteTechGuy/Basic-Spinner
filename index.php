<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/united/bootstrap.min.css">
    <title>Basic Spinner</title>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <h1>Basic Spinner</h1>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card border-primary">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#spinner"><i
                                        class="fa fa-sync fa-spin"></i>
                                Spinner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#words"><i class="fa fa-edit"></i> Kelime Ekle /
                                Kaldır</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active show" id="spinner">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="makale">Makale :</label>
                                    <textarea class="form-control" id="makale" name="makale" rows="8"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success float-right"><i
                                            class="fa fa-sync fa-spin"></i> <b>Spinle</b> <i
                                            class="fa fa-sync fa-spin"></i></button>
                            </form>
                            <div>
                                <h3>Spinlenmiş Makale :</h3>
                            </div>
                            <div>
                                <?php
                                if (isset($_POST['makale'])) {
                                    $words = json_decode(file_get_contents('words.json'), true);
                                    $eski = array();
                                    $yeni = array();
                                    foreach ($words as $word) {
                                        $eski[] = $word['eski'];
                                        $yeni[] = $word['yeni'];
                                    }
                                    $spin = str_replace($eski, $yeni, $_POST['makale']);
                                    echo $spin;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="words">
                            <form action="" class="row" method="post">
                                <div class="form-group col-6">
                                    <label class="col-form-label col-form-label-sm" for="eskiKelime">Eski Kelime</label>
                                    <input class="form-control form-control-sm" type="text" name="eskiKelime"
                                           id="eskiKelime">
                                </div>
                                <div class="form-group col-6">
                                    <label class="col-form-label col-form-label-sm" for="yeniKelime">Yeni Kelime</label>
                                    <input class="form-control form-control-sm" type="text" name="yeniKelime"
                                           id="yeniKelime">
                                </div>
                                <div class="form-group col-12">
                                    <button type="submit" class="btn btn-success float-right"><i class="fa fa-plus"></i><b>
                                            Ekle</b>
                                    </button>
                                </div>
                                <?php
                                if (isset($_POST['eskiKelime']) && isset($_POST['yeniKelime'])) {
                                    $_POST['eskiKelime'] = htmlspecialchars($_POST['eskiKelime']);
                                    $_POST['yeniKelime'] = htmlspecialchars($_POST['yeniKelime']);
                                    $words = json_decode(file_get_contents('words.json'));
                                    $words[] = array('eski' => $_POST['eskiKelime'], 'yeni' => $_POST['yeniKelime']);
                                    file_put_contents('words.json', json_encode($words));
                                    ?>
                                    <div class="col-12 alert alert-dismissible alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <h4 class="alert-heading">Kelime Eklendi !</h4>
                                    </div>
                                    <?php
                                }
                                ?>
                            </form>
                            <hr>
                            <h4>Spin Edilecek Kelimeler</h4>
                            <div class="row">
                                <?php
                                if (isset($_GET['id']) && isset($_GET['sil'])) {
                                    $words = json_decode(file_get_contents('words.json'), true);
                                    array_splice($words, $_GET['id'], 1);
                                    file_put_contents('words.json', json_encode($words));
                                    header('Location:index.php');
                                    ?>
                                    <div class="col-12 alert alert-dismissible alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <h4 class="alert-heading">Kelime Silindi !</h4>
                                    </div>
                                    <?php
                                }

                                $words = json_decode(file_get_contents('words.json'), true);
                                foreach ($words as $key => $word) {
                                    ?>
                                    <div class="col-3">
                                        <span class="badge badge-danger"><?= $word['eski']; ?></span> <i
                                                class="fa fa-long-arrow-alt-right"></i>
                                        <span class="badge badge-success"><?= $word['yeni']; ?></span> -
                                        <a href="?sil&id=<?= $key; ?>" class="badge badge-danger"><i
                                                    class="fa fa-trash"></i>
                                            Sil</a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>