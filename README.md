 Tema: Gerenciador de Filmes

 Resumo do Funcionamento:
Este sistema permite que o usuário se cadastre, faça login, visualize seus filmes favoritos, adicione novos filmes e faça logout. O sistema utiliza MySQL para armazenar as informações do usuário e filmes.

## Usuário/Senha de Teste:
Crie uma conta personalizada para voce Jason !
no link cadastro novo usuario

Passos para Instalação do Banco de Dados:
1. Abra o **phpMyAdmin** e crie um banco de dados chamado **meus_filmes**.
2. Importe o arquivo SQL (**meus_filmes.sql**) fornecido para o banco de dados.
3. No arquivo **`conexao.php`**, configure as credenciais para conectar ao banco de dados:
   - **Host**: localhost
   - **Usuário**: root
   - **Senha**: (deixe em branco, se estiver usando XAMPP)
   - **Banco de dados**: meus_filmes
