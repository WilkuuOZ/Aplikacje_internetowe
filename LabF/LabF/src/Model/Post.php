<?php
namespace App\Model;

use App\Service\Config;

class Post
{
    private ?int $id = null;
    private ?string $subject = null;
    private ?string $model = null;
    private ?int $year = null;
    private ?string $color = null;
    private ?string $engine= null;
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Post
    {
        $this->id = $id;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): Post
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Post
    {
        $this->content = $content;

        return $this;
    }
    public function setModel(?string $model):Post{
        $this->model=$model;
        return $this;
    }
    public function getModel():?string{
        return $this->model;
    }

    public function getYear():?int{
        return $this->year;
    }
    public function setYear(?int $year):Post{
        $this->year=$year;
        return $this;
    }
    public function getColor():?string{
        return $this->color;
    }
    public function setColor(?string $color):Post{
        $this->color=$color;
        return $this;
    }
    public function getEngine():?string{
        return $this->engine;
    }
    public function setEngine(?string $engine):Post{
        $this->engine=$engine;
        return $this;
    }
    public static function fromArray($array): Post
    {
        $post = new self();
        $post->fill($array);

        return $post;
    }

    public function fill($array): Post
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['subject'])) {
            $this->setSubject($array['subject']);
        }
        if (isset($array['model'])) {
            $this->setModel($array['model']);
        }
        if (isset($array['year'])) {
            $this->setYear($array['year']);
        }
        if (isset($array['color'])) {
            $this->setColor($array['color']);
        }
        if (isset($array['engine'])) {
            $this->setEngine($array['engine']);
        }
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM post';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $posts = [];
        $postsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function find($id): ?Post
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM post WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $postArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $post = Post::fromArray($postArray);

        return $post;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO post (subject, content,model,year,color,engine) VALUES (:subject, :content,:model,:year,:color,:engine)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':subject' => $this->getSubject(),
                'model' => $this->getModel(),
                'year' => $this->getYear(),
                'color' => $this->getColor(),
                'engine' => $this->getEngine(),
                ':content' => $this->getContent()
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE post SET subject = :subject, model =: model,year=:year,color=:color,engine=:engine, content = :content WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':subject' => $this->getSubject(),
                'model' => $this->getModel(),
                'year' => $this->getYear(),
                'color' => $this->getColor(),
                'engine' => $this->getEngine(),
                'content' => $this->getContent(),
                ':id' => $this->getId()
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM post WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setSubject(null);
        $this->setModel(null);
        $this->setYear(null);
        $this->setColor(null);
        $this->setEngine(null);
        $this->setContent(null);
    }
}
