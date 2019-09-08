import toastr from 'toastr';

toastr.options = {
  closeButton: true,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: 'toast-bottom-right',
  preventDuplicates: true,
  onclick: null,
  showDuration: '300',
  hideDuration: '100',
  timeOut: 3000,
  extendedTimeOut: 2000,
  showEasing: 'swing',
  hideEasing: 'linear',
  showMethod: 'slideDown',
  hideMethod: 'slideUp',
  closeMethod: 'fadeOut',
  tapToDismiss: false,
};

export default toastr;
