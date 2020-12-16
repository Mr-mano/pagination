<?php
use App\Helpers\Text;
use App\Model\Post;
use App\Http\Request;

$title = 'Mon Blog';

$page = $request->get('page', 1, Request::INT);
$link = $router->url('home'); 
$currentPage = (int)$page;
if ($currentPage <= 0) {
    throw new Exception('Numéro de page invalide');
}
$pdo = $app->getPDO();
$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}
$offset = $perPage * ($currentPage - 1);
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);

$getpage = ($_GET['page'] ?? 1);
?>

<h1>Mon Blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
    <?php if ($currentPage > 1): ?>
        <?php if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1); ?>
            <li class="page-item">
                <a class="page-link" href="<?= $link ?>" class="btn btn-primary">&laquo; Page précédente</a>
            </li>
        <?php endif ?>

        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <li class="page-item <?php if($page === $i) {echo 'active'; } ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <?php if ($currentPage < $pages): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page suivante &raquo;</a>
            </li>
        <?php endif ?>
    </ul>
</nav>


