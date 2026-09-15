# Talk Shift Left

Exemplos simples da palestra Shift Left, mostrando como validar regras de
negócio, testes automatizados, qualidade de código e análise arquitetural desde
o início do desenvolvimento.

## Módulos

- `Account`: spec de criação de contas, validação de nome e e-mail e status
  inicial `active`.
- `Invoice`: processamento de faturas em memória, validações, setters e status
  inicial `pending`.

As especificações estão em:

```text
docs/spec-account.md
docs/spec-invoice.md
```

## Requisitos

- PHP 8.5 ou superior;
- Composer;
- Node.js e `npx`;
- uma chave da OpenRouter para executar as avaliações do Promptfoo.

## Instalação

```bash
composer install
```

O Composer instala o CaptainHook e registra os hooks do Git no repositório.

## Testes PHP

Execute os testes unitários com:

```bash
vendor/bin/phpunit --configuration=phpunit.xml
```

As verificações individuais de qualidade são:

```bash
vendor/bin/php-cs-fixer check --diff --config=.php-cs-fixer.dist.php
vendor/bin/phpstan analyse --configuration=phpstan.neon --no-progress --debug
vendor/bin/deptrac analyse --config-file=deptrac.yaml
```

## Promptfoo

O Promptfoo avalia as specs de `Account` e `Invoice` usando três modelos via
OpenRouter. A configuração é modular:

```text
promptfooconfig.yaml
promptfoo/providers.yaml
promptfoo/prompts/spec-review.txt
promptfoo/tests/account.yaml
promptfoo/tests/invoice.yaml
```

Crie o arquivo `.env` na raiz do projeto a partir do exemplo:

```bash
cp .env-example .env
```

Depois preencha a chave sem versionar o arquivo:

```env
OPENROUTER_API_KEY=sua-chave-aqui
```

Execute a avaliação manualmente com:

```bash
./bin/promptfoo-eval
```

O script carrega a chave da OpenRouter apenas no ambiente do processo. O
Promptfoo está fixado na versão `0.121.1` para manter compatibilidade com o
ambiente atual de Node.js.

## Hooks do Git

O `pre-commit` executa:

- PHP-CS-Fixer;
- PHPStan;
- PHPUnit.

O `pre-push` executa:

- auditoria do Composer;
- Deptrac;
- avaliação das specs com Promptfoo.

Para executar o hook antes do push, é necessário ter um `.env` configurado.
Nunca commit a chave da OpenRouter.

## Estrutura

```text
src/                 código dos módulos PHP
tests/               testes PHPUnit
docs/                especificações funcionais
promptfoo/           prompts, providers e cenários de avaliação
bin/                 scripts auxiliares
captainhook.json     configuração dos hooks
deptrac.yaml         regras arquiteturais
```

## Exemplo de fluxo Shift Left

1. Escrever ou atualizar a spec.
2. Criar os cenários de teste.
3. Implementar o menor comportamento necessário.
4. Executar PHPUnit, PHPStan, PHP-CS-Fixer e Deptrac.
5. Avaliar a clareza da spec com os providers configurados no Promptfoo.
6. Só então realizar o push.
