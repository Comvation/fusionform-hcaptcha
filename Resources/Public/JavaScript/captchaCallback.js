/**
 * Listen to the form submit event
 *
 * Validate the captcha, and submit on success only.
 * Required for invisible mode only.
 */
function captchaLoaded() {
  let form
  const elementContainer = document.querySelector('#captcha-container')
  if (elementContainer) {
    const formSelector = elementContainer.dataset.formSelector
    if (formSelector) {
      form = document.querySelector(formSelector)
      if (!form) {
        console.warn('No form found for selector', formSelector)
      }
    }
  }
  if (!form) {
    const forms = document.forms
    if (forms.length) {
      form = forms[0]
    }
  }
  if (!form) {
    console.warn('No form found, invisible captcha will not work')
    return
  }
  form.addEventListener('submit', captchaValidate)
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
      event.target.submit()
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
