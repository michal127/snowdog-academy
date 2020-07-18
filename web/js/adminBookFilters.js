window.onload = event => {
  const
    bookFiltersForm = document.querySelector('#bookFilters'),
    minBorrowDaysInput = bookFiltersForm.querySelector('#minBorrowDay'),
    bookFilterSubmit = bookFiltersForm.querySelector('#bookFilterSubmit'),
    bookFilterReset = bookFiltersForm.querySelector('#bookFilterReset')

  bookFiltersForm.addEventListener('submit', onFormSubmit)
  minBorrowDaysInput.addEventListener('input', onFilterChange)

  function onFormSubmit (e) {
    e.preventDefault()
    const isResetForm = (e.submitter === bookFilterReset)
    let targetLocation = '/admin'
    if (!isResetForm && minBorrowDaysInput.value > 0) {
      targetLocation += '/books/minDays/' + minBorrowDaysInput.value
    }

    window.location.href = targetLocation
  }

  function onFilterChange () {
    bookFilterSubmit.toggleAttribute('disabled', false)
  }
}