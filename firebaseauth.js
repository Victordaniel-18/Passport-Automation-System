// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyB3Ws3wEvGygvuc8GqfNbKiYsANMgZIrVo",
  authDomain: "sign-up-15438.firebaseapp.com",
  projectId: "sign-up-15438",
  storageBucket: "sign-up-15438.firebasestorage.app",
  messagingSenderId: "797657991270",
  appId: "1:797657991270:web:f430b3e36acb542c0bc5a7",
  measurementId: "G-CW6CEE9QGV"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);