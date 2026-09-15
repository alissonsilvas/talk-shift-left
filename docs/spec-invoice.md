# Spec: módulo Invoice

## Objetivo

Documentar o comportamento mínimo do módulo `Invoice` para servir como exemplo
de desenvolvimento orientado por testes e práticas Shift Left na palestra.

## Escopo

O módulo deve permitir processar uma fatura em memória, sem banco de dados,
filesystem, rede ou integrações externas.

Estrutura esperada:

```text
src/Invoice/Invoice.php
src/Invoice/InvoiceService.php
tests/InvoiceServiceTest.php
```

## Contrato funcional

O serviço deve expor uma operação equivalente a:

```php
$invoice = new InvoiceService()->process(
    'Palestra Shift Left',
    1500,
    new DateTimeImmutable('2026-10-15'),
    'pix'
);
```

O resultado deve ser uma instância de `Invoice` com os dados informados e
status inicial `pending`.

| Campo | Regra |
| --- | --- |
| `description` | Obrigatória; espaços nas extremidades são removidos; não pode ficar vazia |
| `amountInCents` | Obrigatório; deve ser um inteiro maior que zero |
| `dueDate` | Deve ser uma instância de `DateTimeImmutable` |
| `paymentMethod` | Obrigatório; espaços nas extremidades são removidos; não pode ficar vazio |
| `status` | Começa como `pending` |

O objeto deve disponibilizar getters para todos os campos e setters para
alterar `description`, `amountInCents`, `dueDate` e `paymentMethod`, mantendo
as mesmas validações aplicadas na criação.

## Regras de erro

O serviço ou a entidade deve lançar `InvalidArgumentException` quando:

- a descrição for vazia ou contiver apenas espaços;
- o valor for menor ou igual a zero;
- o meio de pagamento for vazio ou contiver apenas espaços.

Não é necessário validar se a data está no futuro nesta versão.

## Critérios de aceite

- [ ] `process()` cria e retorna um `Invoice`.
- [ ] Os dados informados são preservados após a normalização.
- [ ] Uma fatura nova possui status `pending`.
- [ ] A descrição, o valor e o meio de pagamento são validados.
- [ ] Os setters atualizam os dados e repetem as validações.
- [ ] O módulo não depende de `Account` nem de infraestrutura externa.
- [ ] PHPUnit, PHPStan, PHP-CS-Fixer e Deptrac continuam passando.

## Fora de escopo

- Persistência e consulta de faturas.
- Emissão de cobrança ou pagamento.
- Alteração do status da fatura.
- Cálculo de impostos, descontos ou juros.
- Geração de identificador.
- Validação de data futura.
