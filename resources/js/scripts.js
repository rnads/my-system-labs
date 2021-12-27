window.addEventListener('Sweetalert2', event => {
  console.log(event)
  switch (event.detail.type) {
    case 'warning':
      Sweetalert2.fire(event.detail.message, event.detail.title, 'warning')
      break;
    case 'info':
      Sweetalert2.fire(event.detail.message, event.detail.title, 'info')
      break;
    case 'success':
      Sweetalert2.fire(event.detail.message, event.detail.title, 'success')
      break;
    case 'error':
      Sweetalert2.fire(event.detail.message, event.detail.title, 'error')
      break;
    case 'remove':
      Sweetalert2.fire(event.detail.message, event.detail.title, 'remove')
      break;
    case 'clear':
      Sweetalert2.fire(event.detail.message, event.detail.title, 'clear')
      break;
  }
});