dynamikasolucoesweb/laravel-weather
=========================
![php version](https://img.shields.io/packagist/php-v/dynamikasolucoesweb/laravel-weather)
![pkg version](https://img.shields.io/packagist/v/dynamikasolucoesweb/laravel-weather)
![license](https://img.shields.io/packagist/l/dynamikasolucoesweb/laravel-weather)
![quality](https://img.shields.io/scrutinizer/quality/g/dynamikaweb/laravel-weather)
![build](https://img.shields.io/scrutinizer/build/g/dynamikaweb/laravel-weather)

Um componente Blade de clima/previsão do tempo utilizando a API Open-Meteo para Laravel.

Instalação
------------
A maneira preferida de instalar esta extensão é através do [composer] [composer](http://getcomposer.org/download/).

Ou corre

```SHELL
$ composer require dynamikasolucoesweb/laravel-weather "*"
```

ou adicione

```JSON
"dynamikasolucoesweb/laravel-weather": "*"
```

à seção `require` do seu arquivo `composer.json`.

Assets & Customização
------------
Publique os assets usando o comando:

```SHELL
$ php artisan vendor:publish --tag=weather-assets
```

Isso copiará os arquivos para public/vendor/dynamikasolucoesweb/weather.

Uso
------------
Basta chamar o componente Blade em suas views passando as coordenadas (latitude e longitude) desejadas. O componente aceita configurações adicionais para definir o tema visual, a quantidade de dias da previsão ou alternar para o layout compacto.

```HTML
<x-weather-widget lat="-27.4138" lng="-49.6008" dias="4" theme="dark" />
```

```HTML
<x-weather-widget lat="-27.4138" lng="-49.6008" compact="true" theme="light" />
```

⚙️ Parâmetros Disponíveis
------------

| Propriedade | Tipo | Padrão | Descrição |
| :------- | :--: | :--: | :---------- |
| lat | string/float | Obrigatório | Latitude da localização desejada. |
| dias | int | 4 | Quantidade de dias para exibir na previsão (Mínimo: 1, Máximo: 16). |
| cacheDuration | int | 900 | Tempo de permanência dos dados em cache, informado em segundos (Padrão: 15 minutos). |
| theme | string | 'dark' | Define o tema visual do widget ('dark' ou 'light'). |
| compact | bool/string | false | Se definido como true, exibe a versão reduzida de 90px de altura focada no clima atual. |
| transparent | bool/string | false | Se definido como true, remove o fundo e o sombreamento padrão do container do widget. |

## ⚡ Performance & Cache
O componente utiliza nativamente o driver de cache configurado no seu Laravel (Cache::remember) para mitigar o número de requisições externas e otimizar o carregamento da página:
- **Gerenciamento de Chaves**: O cache gera chaves dinâmicas baseadas na combinação exclusiva da latitude, longitude e quantidade de dias pesquisados.
- **Duração Customizável**: Por padrão, os dados climáticos expiram a cada 15 minutos (900 segundos), mas podem ser customizados diretamente na chamada do componente através do atributo cacheDuration.

Features
------------
Modo Compacto Inteligente: Oferece dois layouts nativos (Modo Completo Scrollable com previsão estendida e Modo Compacto Minimalista para barras laterais ou cabeçalhos).

Fallback Seguro: Caso a API externa fique indisponível ou ocorram problemas de rede, o widget trata o erro sem quebrar o restante da aplicação.

Suporte a SSL Local: Ignora automaticamente verificações rígidas de certificados cURL HTTPS em ambientes locais (local) para evitar problemas comuns de ambiente de desenvolvimento.

Ícones Dinâmicos: Mapeamento completo e responsivo integrado aos pacotes de estilização baseados na biblioteca Weather Icons.

Authors
------------
Giordani da Silveira dos Santos - giordani@dynamika.com.br

--------------------------------------------------------------------------------------------------------------
[![dynamika soluções web](https://avatars.githubusercontent.com/dynamikaweb?size=12)](https://dynamika.com.br)
This project is under [BSD-3-Clause](https://opensource.org/licenses/BSD-3-Clause) license.