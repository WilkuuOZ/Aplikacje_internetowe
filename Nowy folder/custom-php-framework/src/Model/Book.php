<?php
namespace App\Model;


use App\Service\Config;

class Book
{
private ?int $id = null;
private ?string $title = null;
private ?string $author = null;
private ?string $isbn = null;

public function getId(): ?int
{
return $this->id;
}

public function setId(?int $id): Book
{
$this->id = $id;

return $this;
}

public function getTitle(): ?string
{
return $this->title;
}

public function setTitle(?string $title): Book
{
$this->title = $title;

return $this;
}

public function getAuthor(): ?string
{
return $this->author;
}

public function setAuthor(?string $author): Book
{
$this->author = $author;

return $this;
}

public function getIsbn(): ?string
{
return $this->isbn;
}

public function setIsbn(?string $isbn): Book
{
$this->isbn = $isbn;

return $this;
}

public static function fromArray($array): Book
{
$book = new self();
$book->fill($array);

return $book;
}

public function fill($array): Book
{
if (isset($array['id']) && ! $this->getId()) {
$this->setId($array['id']);
}
if (isset($array['title'])) {
$this->setTitle($array['title']);
}
if (isset($array['author'])) {
$this->setAuthor($array['author']);
}
if (isset($array['isbn'])) {
$this->setIsbn($array['isbn']);
}

return $this;
}

public static function findAll(): array
{
$pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
$sql = 'SELECT * FROM book';
$statement = $pdo->prepare($sql);
$statement->execute();

$books = [];
$booksArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
foreach ($booksArray as $bookArray) {
$books[] = self::fromArray($bookArray);
}

return $books;
}

public static function find($id): ?Book
{
$pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
$sql = 'SELECT * FROM book WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);

$bookArray = $statement->fetch(\PDO::FETCH_ASSOC);
if (! $bookArray) {
return null;
}
$book = Book::fromArray($bookArray);

return $book;
}

public function save(): void
{
$pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
if (! $this->getId()) {
$sql = "INSERT INTO book (title, author, isbn) VALUES (:title, :author, :isbn)";
$statement = $pdo->prepare($sql);
$statement->execute([
'title' => $this->getTitle(),
'author' => $this->getAuthor(),
'isbn' => $this->getIsbn(),
]);

$this->setId($pdo->lastInsertId());
} else {
$sql = "UPDATE book SET title = :title, author = :author, isbn = :isbn WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute([
':title' => $this->getTitle(),
':author' => $this->getAuthor(),
':isbn' => $this->getIsbn(),
':id' => $this->getId(),
]);
}
}

public function delete(): void
{
$pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
$sql = "DELETE FROM book WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute([
':id' => $this->getId(),
]);

$this->setId(null);
$this->setTitle(null);
$this->setAuthor(null);
$this->setIsbn(null);
}
}