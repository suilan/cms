# IEPTBMA - Instituto de Estudos de Protesto de Títulos do Maranhão

Fundado em 12 de maio de 2004, o Instituto de Estudos de Protesto de Títulos do Brasil - Seção Maranhão (IEPTB/MA), é uma entidade civil sem fins lucrativos de âmbito Estadual e prazo indeterminado. Sediada no Município de São Luís/MA, o IEPTB oferece suporte às serventias da especialidade protesto e aos seus usuários, parceiros e associados.

## Instruções para funcionamento do pacote
Referencia: https://laravel.com/docs/5.4/packages

1. Clonar o repositório 'git@bitbucket.org:ielop/cartorios.git'. Se vc já possuir o projeto, pular essa etapa.
2. Criar a pasta 'packages\ielop' dentro do projeto 'cartorios'.
3. Clonar o seguinte pacote do bitbucket 'git@bitbucket.org:ielop/ieptbma.git' dentro da pasta chamada 'packages/ielop'.
4. No arquivo 'config/app.php' do projeto 'cartorios' adicionar a seguinte linha: 
	'Ielop\Ieptbma\IeptbmaServiceProvider::class' no array chamado 'providers'
5. NÃO ESQUECER DE CHECAR SE JÁ EXISTE VÍRGULA NA LINHA ANTERIOR A LINHA QUE ACABOU DE SER ACRESCENTADAS.
6. Acrescentar na variavel 'psr-4' do arquivo 'composer.json' do projeto 'cartorios' a linha: 
"Ielop\\Ieptbma\\": "packages/ielop/ieptbma/src"
7. NÃO ESQUECER DE CHECAR SE JÁ EXISTE VÍRGULA NA LINHA ANTERIOR A LINHA QUE ACABOU DE SER ACRESCENTADAS.
8. Rodar no terminal\cmd\bash do diretório 'cartorios' o seguinte comando: composer dump-autoload
9. Rodar no terminal\cmd\bash do diretório 'cartorios' o seguinte comando: 
php artisan vendor:publish --force --provider="Ielop\Ieptbma\IeptbmaServiceProvider"
 
