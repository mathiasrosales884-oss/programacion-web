<?php

class UserControllers {

    public function __construct(
        private User $user
    ) {}

    public function index(): void {

        echo json_encode(
            $this->user->getAll()
        );
    }

    public function store(): void {

        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        $id = $this->user->create($data);

        http_response_code(201);

        echo json_encode([
            'mensaje' => 'Usuario creado',
            'id' => $id
        ]);
    }

    public function show(int $id): void {

        $user = $this->user->getById($id);

        if (!$user) {

            http_response_code(404);

            echo json_encode([
                'error' => 'Usuario no creado'
            ]);

            return;
        }

        echo json_encode($user);
    }

    public function update(int $id): void {

        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        $result = $this->user->update($id, $data);

        if ($result === 0) {

            http_response_code(404);

            echo json_encode([
                'error' => 'Usuario no encontrado o sin cambios'
            ]);

            return;
        }

        echo json_encode([
            'mensaje' => 'Usuario actualizado',
            'id' => $id
        ]);
    }

    public function destroy(int $id): void {

        $result = $this->user->delete($id);

        if ($result === 0) {

            http_response_code(404);

            echo json_encode([
                'error' => 'Usuario no encontrado'
            ]);

            return;
        }

        http_response_code(204);
    }
}