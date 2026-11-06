<?php

class User {

    public function __construct(private PDO $db) {}

    public function getAll(): array {

        $stmt = $this->db->query(
            "SELECT * FROM usuario"
        );

        return $stmt->fetchAll();
    }

    public function create(array $data): int {

        $stmt = $this->db->prepare(
            "INSERT INTO usuario (nombre, contrasena, correo )
             VALUES (?, ?, ? )"
        );

        $stmt->execute([
            $data['nombre'],
            $data['contrasena'],
            $data['correo']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function getById(int $id): array|false {

        $stmt = $this->db->prepare(
            "SELECT * FROM usuario WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function update(int $id, array $data): int {

        $stmt = $this->db->prepare(
            "UPDATE usuario
             SET nombre = ?, contrasena = ?, correo = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $data['nombre'],
            $data['contrasena'],
            $data['correo'],
            $id
        ]);

        return $stmt->rowCount();
    }

    public function delete(int $id): int {

        $stmt = $this->db->prepare(
            "DELETE FROM usuario WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->rowCount();
    }
}