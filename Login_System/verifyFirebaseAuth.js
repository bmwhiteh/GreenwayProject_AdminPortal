  var config = {
    apiKey: "AIzaSyD2MKXo--r3wLd-YlpvuAre93fiw154Ukc",
    authDomain: "greenwaytest-aeb36.firebaseapp.com",
    databaseURL: "https://greenwaytest-aeb36.firebaseio.com",
    projectId: "greenwaytest-aeb36",
    storageBucket: "greenwaytest-aeb36.appspot.com",
    messagingSenderId: "726052510477"
  };
  firebase.initializeApp(config);
  
  function checkUser() {
    firebase.auth().onAuthStateChanged(function(user) {
      console.log("Test");
      if (user) {
        alert("user signed in");
      } else {
        window.location = '../Login_System/fireBaseLogin.html';
      }
    });
}