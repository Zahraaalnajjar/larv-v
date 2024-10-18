<template>
    <div id="loginApp">

        <section id="loginBody" class="login-frame">
            <div class="frame-bg"></div>
            <div class="frame-opacity"></div>

            <div class="frame-container">

                <main class="UI-frame">

                    <div class="Animation-frame">

                        <div class="SwitchUI-frame">

                            <div class="SwitchUI-content"></div>

                        </div>

                        <div class="LogInUI-frame" id="uiFrame1">
                            <div class="LogInUI-bg"></div>
                            <div class="LogInUI-bg-opacity"></div>

                            <div class="LogInUI-contenter" id="loginPanel">

                                <div class="slide-frame" id="slideUIFrameLogin">
                                    <div class="LogInUI-contenter-title">
                                        <div> Login</div>
                                    </div>

                                    <div class="LogInUI-contenter-section">
                                        <div> User ID: </div>
                                        <input type="number" ref="id" name="id"> <!-- Changed type to text and ref to "id" -->
                                        <br>
                                        <div>Password: </div>
                                        <input type="password" ref="password" name="password"> <!-- Added ref="password" -->
                                        <br>
                                        <button @click="login">Log in</button>
                                        <br>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </main>
            </div>
        </section>

        <!-- Router link page -->

        <router-link v-if="isAuthenticated" to="/router-link-page">Router Link Page</router-link>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isAuthenticated: false,
        };
    },
    mounted() {
        // Check if the user is authenticated based on the presence of the token

    },

    methods: {
        login() {
            // Retrieve user credentials
            const id = this.$refs.id.value.trim();
            const password = this.$refs.password.value.trim();

            // Send login request
            axios.post('http://127.0.0.1:8000/api/login/', {id, password})
                .then(response => {
                    const { message, token, active_login_status } = response.data;

                    if (token) {
                        // Save token to local storage
                        localStorage.setItem('token', token);

                        // Check active_login_status and redirect accordingly
                        if (active_login_status === 1 )  {
                            // Redirect first user to specific page
                            this.$router.push({path: '/onlyList', query: {reload: true}});
                        } else if (active_login_status === 2) {
                            // Redirect second user to specific page
                            this.$router.push({path: '/', query: {reload: true}});
                        } else {
                            // Handle other cases
                            console.error('Unexpected active_login_status:', active_login_status);
                        }
                    } else {
                        console.error('No token received.');
                    }
                })
                .catch(error => {
                    console.error(error.response.data.message);
                });
        }
    },



    };
</script>


<style>
body{
    margin: 0;
}
/* unvisited link */
a:link {
    text-decoration: none;
    color: #333;
}
/* visited link */
a:visited {
    text-decoration: none;
    color: #333;
}
/* mouse over link */
a:hover {
    text-decoration: none;
    color: #333;
}
/* selected link */
a:active {
    text-decoration: none;
    color: #333;
}

.fbLogin:link{
    text-decoration: none;
    color:#99b3ff;

}










/*
  Section 背景
*/

.login-frame{
    z-index: 2;
    width: 100%;
    height: 100vh;
    background-color: black;

}
.frame-bg{

    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    top: 0;

    background-size: contain; /* Use 'contain' to maintain aspect ratio */
    background-repeat: no-repeat;
    background-position: center center;
    background-image: url("/img/myim.png"); /* Updated path */
}
.frame-opacity{
    position: relative;
    z-index: 2;
    width: 100%;
    height: 100vh;
    top: -100vh;
    background-color: #333;
    opacity: 0.4;
}
.frame-container{
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 3;
    width: 100%;
    height: 100vh;
    top: -200vh;

}

/*
  UI frame
*/

.Animation-frame{
    flex: none;
    z-index: 5;
    width: 1000px;
    height: 500px;
}
/*
  Switch UI panel
*/

.SwitchUI-content{
    position: relative;
    display: flex;
    justify-content: space-between;
    z-index: 9;
    top: -800px;
    width: 1000px;
    height: 400px;

}

.LogInUI-frame{
    flex: none;
    position: relative;
    z-index: 10;
    top: -400px;
    width: 400px;
    height: 500px;
    color: white;
    box-shadow: 0 10px 20px 0 rgba(0, 0, 0, 0.4), 0 10px 30px 0 rgba(0, 0, 0, 0.5);
    overflow: hidden;
    border-radius: 0px;
    margin-left: 20px;
    transition: margin-left  0.8s;
}
.LogInUI-bg{
    position: relative;
    z-index:11;
    width: 400px;
    height: 500px;
    /*background-image: url('../img/bg02.jpg');*/
    /*
    background-image: linear-gradient(-90deg, rgb(0, 191, 255) , rgb(0, 115, 153));
    */
    background-size: cover;
}
.LogInUI-bg-opacity{
    position: relative;
    z-index: 12;
    width: 400px;
    height: 500px;
    top: -500px;
    background-image: linear-gradient(90deg, #666666, #333333);
    opacity: 0.6;

}
.LogInUI-contenter{
    position: relative;
    z-index: 13;
    display: flex;
    width: 9000px;
    height: 500px;
    top: -1000px;

}

.LogInUI-contenter-title{
    width: 400px;
    height: 60px;
    /*
    background-image: linear-gradient(-90deg, #666666, #333333);
    */
    color: white;
    font-size: 26px;
}
.LogInUI-contenter-title > div{
    margin-top: 10px;
    margin-left: 10px;
}

.LogInUI-contenter-section > div{
    margin-left: 50px;
    margin-top: 35px;
    font-size: 18px;
}
.LogInUI-contenter-section > input{

    width: 300px;
    height:34px;
    margin-top: 5px;
    margin-left: 50px;
    background-color: #fff3;
    border-radius: 5px;
    border-style: solid;
    border-color: #fff;
    color: white;
    font-size: 18px;
}

.LogInUI-contenter-section > button{

    width: 120px;
    height: 40px;
    margin-left: 50px;
    margin-top: 20px;
    background-color: #fff0;
    border:2px solid #fff;
    text-align: center;
    font-size: 20px;
    color: #fff;
    cursor: pointer;
}
.LogInUI-contenter-section > button:hover{

    width: 120px;
    height: 40px;
    margin-left: 50px;
    margin-top: 20px;
    background-color: #fff;
    border:2px solid #fff;
    text-align: center;
    font-size: 20px;
    color: #333;
    cursor: pointer;
}





</style>
