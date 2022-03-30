# BoloStore

Está API irá fazer os cadastro e edição de bolos. Também haverá o cadastro de interessados nesses bolos, informando o email, assim no final será possível enviar para cada email uma lista com os bolos do interesse do usuario.

<br>

## Instalação

Criar um banco de dados e o configure no '.env', também configurar as informações de email no mesmo arquivo. Consulte '.env-example' para ver os parametros necessários.

<br>

Para rodar as migrations
```
php artisan migrate
```

Para rodar o seeder de bolos (irá inserir 5 bolos)
```
php artisan db:seed --class=CakeSeeder
```

Para rodar o seeder de interessados (irá inserir 50000 interessados)
```
php artisan db:seed --class=InterestedSeeder
```


Iniciar o processamento da fila
```
php artisan queue:work
```





<br>


## Rotas Api

### **Rotas dos Bolos**
Retorna uma lista com todos os bolos
```
GET:api/cake
```

Retorna os dados de um bolo
```
GET:api/cake/show/{nome_bolo}
```

Grava no banco um novo bolo

Parametros da requisição: 
* **name** = nome do bolo (string), 
* **weight** = peso do bolo em gramas (decimal),
* **value** = valor do bolo (decimal), 
* **quantity** = quantidade (int)

```
PUT:api/cake/store
```


Atualiza as informações de um bolo existente

Parametros da requisição: 
* **weight** = peso do bolo em gramas (decimal),
* **value** = valor do bolo (decimal), 
* **quantity** = quantidade (int)

```
POST:api/cake/update/{nome_bolo}
```

Remove um bolo existente
```
DELETE:api/cake/delete/{nome_bolo}
```






<br>

### **Rotas dos Interessados**

Retorna uma lista com todos os interessados
```
GET:api/interested
```

Grava no banco um novo interesse

Parametros da requisição: 
* **name** = nome do bolo existente (string), 
* **email** = email do interessado, existente ou não (string)

```
PUT:api/interested/store
```

Remove um interesse existente
```
DELETE:api/interested/delete/{nome_bolo}/{email}
```

Exibe os interessados por um bolo
```
GET:api/interested/show/{nome_bolo}
```




<br>

### **Rotas de Email**
Envia os emails aos interessados quando houver quantidade de bolo maior que zero
```
GET:/api/sendemails
```



