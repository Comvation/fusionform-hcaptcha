/**
 * Listen to the submit button click event
 *
 * Validate the captcha, and submit on success only.
 * Required for invisible mode only.
 */
function captchaLoaded() {
  const elementContainer = document.querySelector('#captcha-container')
  if (elementContainer) {
    const selector = elementContainer.dataset.selector
    if (selector) {
      const elementSubmit = document.querySelector(selector)
      if (elementSubmit) {
        elementSubmit.onclick = captchaValidate
        return
      }
      console.warn('Invalid selector, or element not found:', selector)
    }
  }
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
  hcaptcha.execute(null, { async: true })
    .then(() => {
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
