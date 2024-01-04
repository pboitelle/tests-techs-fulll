/*
  * FizzBuzz function
  * @param {HTMLInputElement} element
  * @return {void}
*/
export function fizzbuzz(element) {

  // Add event listener to the input element
  element.addEventListener('input', () => {

    const number = element.value

    const ul = document.querySelector('#result')
    ul.innerHTML = ''

    // Loop from 1 to the number
    for (let i = 1; i <= number; i++) {

      let result = ''

      if (i % 3 === 0 && i % 5 === 0) {
        result += 'FizzBuzz'
      } else if (i % 3 === 0) {
        result += 'Fizz'
      } else if (i % 5 === 0) {
        result += 'Buzz'
      } else {
        result += i
      }

      // print the result in the ul element
      const li = document.createElement('li')
      li.innerHTML = result
      ul.appendChild(li)
    }
  })
}
