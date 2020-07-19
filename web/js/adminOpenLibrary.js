const isbnInput = document.querySelector('#isbn'),
  fetchBtn = document.querySelector('#isbnFetch'),
  fetchBtnSpinner = fetchBtn.querySelector('.fa-spinner'),
  openLibraryDataContainer = document.querySelector('#openLibraryData'),
  openLibraryAuthors = openLibraryDataContainer.querySelector('#openLibraryAuthors'),
  openLibraryTitle = openLibraryDataContainer.querySelector('#openLibraryTitle'),
  openLibraryPubYear = openLibraryDataContainer.querySelector('#openLibraryPubYear'),
  openLibraryCover = openLibraryDataContainer.querySelector('#bookCover'),
  openLibraryUrl = openLibraryDataContainer.querySelector('#openLibraryUrl'),
  openLibraryError = document.querySelector('#openLibraryError')

isbnInput.addEventListener('input', function (e) {
  fetchBtn.toggleAttribute('disabled', !e.target.value)
})

fetchBtn.addEventListener('click', async function () {
  const isbnValue = isbnInput.value
  if (isbnValue) {
    toggleHidden(fetchBtnSpinner, false)
    let responseData = await fetchOpenLibraryApiData(isbnValue)
    toggleHidden(fetchBtnSpinner, true)

    if (Object.keys(responseData).length > 0) {
      insertData(responseData[Object.keys(responseData)[0]])
    } else {
      handleError()
    }
  }
})

function insertData (bookData) {
  toggleHidden(openLibraryDataContainer, false)
  toggleHidden(openLibraryError, true)
  openLibraryTitle.innerHTML = (bookData.title) ? bookData.title : '-'
  openLibraryAuthors.innerHTML = (bookData.authors) ? getAuthors(bookData.authors) : '-'
  openLibraryPubYear.innerHTML = (bookData.publish_date) ? bookData.publish_date : '-'
  openLibraryCover.src = (bookData.cover.medium) ? bookData.cover.medium : ''

  if (bookData.url) {
    openLibraryUrl.href = bookData.url
    toggleHidden(openLibraryUrl, false)
  } else {
    openLibraryUrl.href = '#'
    toggleHidden(openLibraryUrl, true)
  }
}

function handleError () {
  toggleHidden(openLibraryError, false)
  toggleHidden(openLibraryDataContainer, true)
  openLibraryTitle.innerHTML = '-'
  openLibraryAuthors.innerHTML = '-'
  openLibraryPubYear.innerHTML = '-'
  openLibraryCover.src = ''
  openLibraryUrl.href = '#'
}

function getAuthors (authorsList) {
  return authorsList.map(elem => elem.name).join(', ')
}

function toggleHidden (elem, hide) {
  (hide) ? elem.classList.add('hidden') : elem.classList.remove('hidden')
}

async function fetchOpenLibraryApiData (isbn) {
  try {
    const response = await fetch('https://openlibrary.org/api/books?bibkeys=ISBN:' + isbn + '&jscmd=data&format=json')
    return await response.json()
  } catch (e) {
    return {}
  }
}