
/*==========
   starting animation
============*/

let formBtn = document.querySelector('#openform-icon')
formBtn.addEventListener('click', () => {

  scale('formcontainer', 'in', .7)

})

/*==========
    show password
============*/

let visible = document.querySelectorAll('.icon')
visible.forEach(el => {

  el.addEventListener('click', function () {

    let passwordSelect = el.parentNode.previousSibling.previousSibling

    passwordSelect.type === 'password' ? passwordSelect.type = 'text' : passwordSelect.type = 'password'

    el.classList.toggle('fa-eye')
    el.classList.toggle('fa-eye-slash')

  })

});

let switchToLogin = document.querySelector('#switch')
switchToLogin.addEventListener('click', function () {
  slide('login', 'in', .8)
  slide('myform', 'out', .8)
})

let switchToSignup = document.querySelector('#switch2')
switchToSignup.addEventListener('click', function () {
  slide('login', 'out', .8)
  slide('myform', 'in', .8)
})


