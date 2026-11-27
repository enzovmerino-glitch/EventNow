# Modelagem do banco de dados

```mermaid
erDiagram
    USUARIOS ||--o{ EVENTOS : organiza
    USUARIOS ||--o{ INSCRICOES : faz
    EVENTOS ||--o{ INSCRICOES : recebe

    USUARIOS {
        int id PK
        varchar nome
        varchar email UK
        char cpf UK
        varchar senha
        timestamp criado_em
    }
    EVENTOS {
        int id PK
        int organizador_id FK
        varchar titulo
        text descricao
        varchar categoria
        datetime data_evento
        time hora_fim
        varchar local_nome
        varchar endereco
        varchar cidade
        char uf
        int capacidade
        decimal preco
        varchar imagem
        timestamp criado_em
    }
    INSCRICOES {
        int id PK
        int evento_id FK
        int usuario_id FK
        timestamp criado_em
    }
```

- Um usuário pode organizar vários eventos e se inscrever em vários.
- Cada evento recebe várias inscrições; `UNIQUE (evento_id, usuario_id)` impede inscrição duplicada.
- Vagas restantes = `capacidade` menos a contagem de `inscricoes` do evento.
