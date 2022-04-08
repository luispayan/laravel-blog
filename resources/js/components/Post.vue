<template>
  <div class="row">
      <div class="col-12 text-center mt-3">
        <span class="title">Create API Rest with Laravel 5.6 Passport Authentication (Part 1)</span>
      </div>
      <div class="col-12 d-flex ml-2 mt-3">
          <img src="/img/user.png" alt="User" class="profile-pick mr-2">
          Luis Payan
      </div>
      <div class="col-12 img-continer text-center mb-2">
          <img src="/img/laravel.jpeg" alt="Laravel Logo" class="img-fluid">
      </div>
      <section v-for="(step, index) in steps" :key="`step${index}`" class="mt-4 w-100">
        <div class="col-12 subtitle mb-2">
            {{step.title}}
        </div>
        <div class="col-12 description">
            {{step.description}}
        </div>
        <div class="col-12 code mt-2 pl-2 d-flex">
            {{step.code}}
        </div>
      </section>
  </div>
</template>

<script>
export default {
    data: function(){
        return {
            steps: [
                {
                    title: 'Step 1. Install Laravel',
                    description: 'In first step, we require to get fresh Laravel application using bellow command, So open your terminal or command prompt and run bellow command:',
                    code: 'laravel new auth'
                },
                {
                    title: 'Step 2. Install Laravel Passport Package',
                    description: 'Laravel Passport provides a full OAuth2 server implementation for your Laravel application in a matter of minutes.',
                    code: 'composer require laravel/passport'
                },
                {
                    title: 'Step 3. Run Migration',
                    description: 'The Passport migrations will create the tables your application needs to store clients and access tokens.',
                    code: 'php artisan migrate'
                }
            ]
        }
    }

}
</script>

<style>
.title{
    font-size: 22px;
    font-weight: bold;
}

.subtitle{
    font-size: 18px;
    font-weight: bold;
}
.description{
    font-size: 18px;
}

.code{
    background-color: #eee;
    align-items: center;
    width: 100%;
    height: 3em;
    font-size: 16px;
}

.d-flex{
    align-items: center;
}

.profile-pick{
    width: 2em;
    height: 2em;
}
</style>