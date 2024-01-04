import './style.css'
import { fizzbuzz } from './fizzbuzz.js'

document.querySelector('#app').innerHTML = `
  <div>

    <h1>FizzBuzz - From 1 to N</h1>

    <div>
      <label for="number">Number: </label>
      <input id="number" type="number" />
    </div>

    <ul id="result"></ul>

  </div>
`

fizzbuzz(document.querySelector('#number'))