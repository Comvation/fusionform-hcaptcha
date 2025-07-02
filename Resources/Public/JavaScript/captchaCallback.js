/**
 * Listen to the submit button click event
 *
 * Validate the captcha, and submit on success only.
 * Required for invisible mode only.
 */
function captchaLoaded(/*...args*/) { // No arguments
  const elementSubmit = document.querySelector('button[type=submit]')
  elementSubmit.onclick = captchaValidate
}

/**
 * Call the hCaptcha validation
 *
 * Required for invisible mode only.
 */
function captchaValidate(event) {
  event.preventDefault()
  // NTH: Only call this (once) *after* validating the form/fields
  hcaptcha.execute(null, { async: true })
    // The key is apparently empty, and of no use here.
    .then(({ token, key }) => {
      // DO NOT // event.target.click() // as this will loop.
      event.target.form.submit()
    })
    .catch(err => {
      console.error(err)
    })
}

/**
 * Update the hidden token form element
 *
 * Called when the user successfully validates the captcha.
 * Required iff the token must be passed along for verification.
*/
function captchaCallback(token) {
  document.getElementById('captcha-token').value = token
}
