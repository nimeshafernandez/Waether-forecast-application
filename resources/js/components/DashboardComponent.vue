<template>
    <div class="div">


        <div class="container-fluid">

            <div class="container-fluid px-1 px-sm-3 py-5 mx-auto">
    <div class="row d-flex justify-content-center">
        <div class="row card0">
            <div class="card1 col-lg-8 col-md-7">
                <div class="text-center"> <img class="image mt-20" src="https://i.pinimg.com/736x/ef/a1/b6/efa1b6dcf525f4ec483c068374e6f005--website-layout-web-layout.jpg"> </div>
                <div class="row px-3 mt-3 mb-3">
                    <h1 class="large-font mr-8">28&#176;</h1>
                    <h1 class="large-font mr-3">{{title}}</h1>
                    <div class="d-flex flex-column mr-3">
                          <h3 class="small-font mr-4">10:36 - 2021/10/16</h3>
                    </div>
                    <div class="d-flex flex-column text-center">
                         <h2 class="large-font mr-8">Sunny</h2>
                    </div>
                </div>
            </div>
            <div class="card2 col-lg-4 col-md-5"><br><br>
                   <button type="button" class="btn btn-primary">Search Location</button>
                <div class="row px-3"> <input type="text" name="location" placeholder="Another location" class="mb-5">


                <!-- <img src="{{hdurl}}" alt="Image"> -->

                </div>
                <div class="mr-5">
                    <p class="light-text suggestion">{{explanation}}</p>
                    <!-- <p class="light-text suggestion">Manchester</p>
                    <p class="light-text suggestion">New York</p>
                    <p class="light-text suggestion">California</p> -->
                    <div class="line my-5"></div>
                    <p>Weather Details</p>
                    <div class="row px-3">
                        <p class="light-text">Cloudy</p>
                        <p class="ml-auto">12%</p>
                    </div>
                    <div class="row px-3">
                        <p class="light-text">Humidity</p>
                        <p class="ml-auto">78%</p>
                    </div>
                    <div class="row px-3">
                        <p class="light-text">Wind</p>
                        <p class="ml-auto">1km/h</p>
                    </div>
                    <div class="row px-3">
                        <p class="light-text">Rain</p>
                        <p class="ml-auto">0mm</p>
                    </div>
                    <div class="line mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</template>



<script>
export default {

    data() {
        return {
            wh_list: {},
            img_list: {},

        }
    },

    mounted() {
        axios.get("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY")
            .then((response) => {
                this.wh_list = response.data;
            }),

        axios.get("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY")
            .then((response) => {
                this.img_list = response.data;
            }),


            axios.get("http://dev.restapi/api/products")
            .then((response) => {
                this.list = response.data;
            })
    }

}
</script>


<style lang="scss" scoped>
body {
    color: rgb(252, 252, 252);
    overflow-x: hidden;
    height: 100%;
    background-image: linear-gradient(#81D4FA, #2196F3);
    background-repeat: no-repeat
}

.card0 {
    width: 94%
}

.card1 {
    background-image: linear-gradient(#0f0f64, #0099b4);
    padding: 30px 20px 30px 50px;
    color:red;
}

.image {
    width: 300px;
    height: 300px
}

.large-font {
    font-size: 70px;
    font-family: Arial
}

.fa-sun-o {
    font-size: 22px
}

.card2 {
    background-color: #01070a;
    padding: 0px 0px 40px 40px
}

input {
    background-color: #e7eff3;
    padding: 24px 0px 12px 0px !important;
    width: 80%;
    box-sizing: border-box;
    border: none !important;
    border-bottom: 1px solid #CFD8DC !important;
    font-size: 16px !important;
    color: #fff !important
}

input:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border-bottom: 1px solid #fff !important;
    outline-width: 0;
    font-weight: 400
}

::placeholder {
    color: #B0BEC5 !important;
    opacity: 1
}

:-ms-input-placeholder {
    color: #B0BEC5 !important
}

::-ms-input-placeholder {
    color: #B0BEC5 !important
}

.fa-search {
    color: #607D8B;
    background-color: #E1F5FE;
    font-size: 20px;
    padding: 20px;
    width: 20%;
    cursor: pointer
}

.light-text {
    color: #B0BEC5
}

.suggestion:hover {
    color: #fff;
    cursor: pointer
}

.line {
    height: 1px;
    background-color: #B0BEC5
}

@media screen and (max-width: 500px) {
    .card1 {
        padding-left: 26px
    }
}
</style>
