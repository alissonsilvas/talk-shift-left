# Spec: módulo Account

## Objetivo

Adicionar um módulo pequeno de contas para servir como exemplo prático da
palestra Shift Left. A implementação deve permitir discutir regra de negócio,
testes automatizados, análise estática e dependências entre módulos sem
introduzir infraestrutura externa.

## Escopo

O módulo deve criar uma conta com nome e e-mail e iniciar a conta com status
`active`. Não haverá banco de dados, persistência, autenticação, envio de
e-mail ou integração com outro serviço.

Estrutura esperada:

```text
src/Account/Account.php
src/Account/AccountService.php
tests/AccountServiceTest.php
```

O módulo `Account` deve ser autocontido e não deve depender de `Invoice`.

## Contrato funcional

O serviço deve expor uma operação equivalente a:

```php
$account = new AccountService()->open(
    'Ada Lovelace',
    'ada@example.com'
);
```

O resultado deve ser uma instância de `Account` com:

| Campo | Regra |
| --- | --- |
| `name` | Obrigatório; espaços nas extremidades são removidos; não pode ficar vazio |
| `email` | Obrigatório; espaços nas extremidades são removidos; deve ser um e-mail válido |
| `status` | Sempre começa como `active` |

O objeto deve disponibilizar leitura dos três valores por meio de getters.
Alterações por setters não fazem parte desta primeira versão.

## Regras de erro

`AccountService::open()` deve lançar `InvalidArgumentException` quando:

- o nome for vazio ou contiver apenas espaços;
- o e-mail for vazio, inválido ou contiver apenas espaços.

As mensagens podem ser escolhidas pela implementação, desde que a exceção e
as regras sejam preservadas.

## Critérios de aceite

- [ ] `open()` cria e retorna um `Account`.
- [ ] Nome e e-mail são preservados após a normalização com `trim()`.
- [ ] Uma conta nova possui status `active`.
- [ ] Nome inválido é rejeitado.
- [ ] E-mail vazio ou inválido é rejeitado.
- [ ] O módulo não possui dependências de banco, filesystem, rede ou pacotes
      adicionais.
- [ ] O teste do módulo passa com PHPUnit.
- [ ] PHPStan, PHP-CS-Fixer e Deptrac continuam passando.
- [ ] A camada arquitetural `Account` contém apenas classes de
      `src/Account` e depende somente de si mesma.

## Cenários mínimos de teste

1. Abre uma conta e verifica o tipo retornado.
2. Verifica nome, e-mail e status da conta criada.
3. Verifica que nome vazio lança `InvalidArgumentException`.
4. Verifica que e-mail inválido lança `InvalidArgumentException`.
5. Verifica que valores com espaços nas extremidades são normalizados.

## Fora de escopo

- ID ou geração de identificador único.
- Login, senha e permissões.
- Confirmação de e-mail.
- Atualização, exclusão, busca ou listagem de contas.
- Persistência e integração entre `Account` e `Invoice`.

## Sequência sugerida para a palestra

1. Escrever os cenários em `tests/AccountServiceTest.php`.
2. Criar o mínimo de `AccountService` para fazer o teste de criação passar.
3. Extrair as validações para `Account` e cobrir os casos inválidos.
4. Rodar PHPUnit, PHPStan, PHP-CS-Fixer e Deptrac a cada etapa.
5. Mostrar que o novo módulo permanece isolado de `Invoice`.
