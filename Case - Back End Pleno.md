# Case - Back End Pleno

**Case: Desenvolvimento de um Sistema CRUD para Gestão de Projetos de Energia Solar**

**O Teste:**
Teste para candidatos à vaga de Desenvolvedor Backend Laravel Júnior e Pleno. O teste é o mesmo para os dois níveis! Nós fazemos isso esperando que os devs mais iniciantes entendam qual o modelo de profissional que temos por aqui e que buscamos para o nosso time.

Nós não definimos um tempo limite para resolução deste teste, o que vale para nós e o resultado final e a evolução da criação do projeto até se atingir este resultado, mas acreditamos que este desafio pode ser resolvido em cerca de 16 horas de codificação.

**Objetivo:**
O desafio consiste na implementação de um sistema CRUD (Create, Read, Update, Delete) utilizando a framework Laravel em PHP, com foco na gestão de projetos de energia solar, implementando testes unitários para garantir a qualidade do código e fornecendo documentação abrangente para facilitar o entendimento e manutenção do sistema.

**Descrição do Sistema:**
O sistema será uma aplicação voltada para empresas que atuam no setor de energia solar, permitindo o cadastro, visualização, atualização e exclusão de informações relacionadas aos projetos de energia solar, incluindo dados sobre clientes, local da instalação e equipamentos.

Para contextualizar melhor, um integrador solar, que seria o principal usuário deste sistema, é alguém que comercializa projetos solares para clientes interessados em adquirir uma usina solar. A aplicação que você está prestes a desenvolver destina-se a esse integrador, permitindo que ele gerencie seus projetos e clientes.

Cada cliente pode estar associado a vários projetos, sendo fundamental destacar que não pode haver um projeto sem um cliente correspondente. Neste projeto, há diversas informações essenciais que o integrador precisará ser capaz de modificar, tais como:

- A identificação do cliente para o qual o projeto está sendo desenvolvido.
- A localização onde o projeto será instalado (vamos nos concentrar apenas na UF).
- O tipo de instalação, que se refere ao tipo de telhado no local onde o cliente planeja instalar a usina.
- Por último, os equipamentos necessários. Vamos nos ater apenas às categorias de equipamentos. Será importante para o integrador ser capaz de remover, adicionar e alterar a quantidade dos itens para cada projeto.

Esta é a aplicação que você precisa desenvolver. Concentre-se em criar a melhor aplicação possível para o integrador solar!

**Requisitos Funcionais:**

1. Cadastro de novos projetos de energia solar, incluindo informações sobre cliente, localização, tipo de instalação e equipamentos utilizados.
2. Listagem de todos os projetos cadastrados, com opção de filtragem e busca.
3. Visualização dos detalhes de um projeto específico, incluindo dados do cliente, localização e equipamentos.
4. Cada projeto terá uma lista de equipamentos cada um com sua quantidade.
5. Atualização dos dados de um projeto existente, incluindo a possibilidade de alterar quantidade, adicionar ou remover equipamentos.
6. Exclusão de um projeto do sistema.
7. Uma listagem para as informações de tipo de instalação e de equipamentos.
8. Deve ser possível cadastrar, editar e excluir um cliente.
9. Clientes e projetos tem uma relacionamento um para muitos (ou seja, um cliente pode ter diversos projetos).
10. Implementação de testes unitários para as principais funcionalidades do sistema.

O cliente deve ter as seguintes informações:

- `Nome`
- `E-mail`
- `telefone`
- `CPF ou CNPJ` (importante haver uma validação se o documento é valido)

A localização será apenas a informação UF onde o projeto será instalado.

Ex:

- `SP`
- `RJ`
- `AM`
- `[…]`

*Para os tipos de instalação, você pode considerar os seguintes itens:*

- `Fibrocimento (Madeira)`
- `Fibrocimento (Metálico)`
- `Cerâmico`
- `Metálico`
- `Laje`
- `Solo`

*Para os equipamentos, você pode considerar os seguintes itens:*

- `Módulo`
- `Inversor`
- `Microinversor`
- `Estrutura`
- `Cabo vermelho`
- `Cabo preto`
- `String Box`
- `Cabo Tronco`
- `Endcap`

**Requisitos Técnicos:**

1. Utilizar Laravel como framework PHP para o desenvolvimento.
2. Utilizar Docker para conteinerização do projeto.
3. Escrever testes unitários utilizando PHPUnit para garantir a qualidade e a estabilidade do código.
4. Utilizar banco de dados MySQL para persistência dos dados.
5. Fornecer documentação detalhada do sistema, incluindo descrição das entidades, endpoints da API, instruções de instalação e uso do sistema.
6. Utilizar o Swagger para documentar as rotas da aplicação, incluindo seus parâmetros e retornos.

**Entrega Esperada:**

1. Código fonte do sistema desenvolvido utilizando Laravel.
2. Testes unitários implementados para cobrir as funcionalidades principais do sistema.
3. Documentação completa do sistema, abordando todos os aspectos relevantes para sua utilização e manutenção.
4. Apresentação técnica do sistema, demonstrando as funcionalidades implementadas e explicando a arquitetura utilizada.

**Critérios de Avaliação:**

1. Cobertura de testes unitários para as funcionalidades críticas do sistema.
2. Clareza e abrangência da documentação fornecida.
3. Funcionamento correto e eficiente das funcionalidades do sistema.
4. Organização e legibilidade do código fonte.
5. Conhecimento do Framework.
6. Boas práticas de Programação (código limpo).
7. Boas práticas de versionamento de Código.

**Importante:** Não é necessário trabalhar no desenvolvimento do front-end, pois isso não será considerado na avaliação.

Este case proporciona uma oportunidade para demonstrar suas habilidades de desenvolvimento em Laravel, assim como sua capacidade de seguir boas práticas de engenharia de software e fornecer documentação detalhada. Boa sorte!

[Job Description](https://www.notion.so/Job-Description-bd9e05cecca64e81a453d7b96ded1bba?pvs=21)