// Небольшие улучшения UX
document.addEventListener('DOMContentLoaded', function(){
  // фокус на первом инпуте формы, если есть
  var firstInput = document.querySelector('form input');
  if(firstInput) firstInput.focus();
});
