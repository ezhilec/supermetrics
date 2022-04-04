import React, { useMemo } from 'react'
import cn from 'classnames'
import PropTypes from 'prop-types'
import './index.scss'

function Pagination (props) {
  const {
    onPageChange,
    currentPage,
    itemsPerPage,
    totalItems,
    maxSiblings = 5
  } = props

  const handleChangePage = (page) => () => {
    onPageChange(page)
  }

  //const pagesList = useMemo(() => {
  const pagesList = () => {
    const totalPages = Math.ceil(totalItems / itemsPerPage)

    let startPage = currentPage - maxSiblings > 1
      ? currentPage - maxSiblings
      : 1

    let finishPage = currentPage + maxSiblings < totalPages
      ? currentPage + maxSiblings
      : totalPages

    if (totalPages > maxSiblings) {
      if (startPage === 1) {
        finishPage += maxSiblings - currentPage
      }

      if (finishPage === totalPages) {
        startPage = startPage - maxSiblings + (totalPages - currentPage)
      }
    }

    const pagesArray = []

    if (currentPage - maxSiblings > 1) {
      pagesArray.push(1)
    }
    if (currentPage - maxSiblings > 2) {
      pagesArray.push('...')
    }

    for (let i = startPage; i <= finishPage; i++) {
      pagesArray.push(i)
    }

    if (currentPage + maxSiblings < totalPages - 1) {
      pagesArray.push('...')
    }

    if (currentPage + maxSiblings < totalPages) {
      pagesArray.push(totalPages)
    }

    return pagesArray
    // }, [
    //   currentPage,
    //   itemsPerPage,
    //   totalItems,
    //   maxSiblings
    // ])
  }

  const lastPage = useMemo(() => {
    return pagesList().pop()
  }, [pagesList()])

  const renderPages = () => {
    return pagesList().map((item, index) => (
      Number.isInteger(item)
        ? <div
          key={index}
          onClick={handleChangePage(item)}
          className={cn('pagination__item', {
            'pagination__item_active': currentPage === item
          })}
        >
          <span>{item}</span>
        </div>
        : <div
          key={index}
          className="pagination__item-space"
        >
          {item}
        </div>
    ))
  }

  if (totalItems === 0) {
    return null
  }

  return (
    <ul className="pagination">
      <li
        onClick={currentPage > 1 ? handleChangePage(currentPage - 1) : null}
        className={cn('pagination__item', {
          'pagination__item_disabled': currentPage === 1
        })}
      >
        &larr;
      </li>

      {renderPages()}

      <li
        onClick={currentPage < lastPage ? handleChangePage(currentPage + 1) : null}
        className={cn('pagination__item', {
          'pagination__item_disabled': currentPage === lastPage
        })}
      >
        &rarr;
      </li>
    </ul>
  )
}

Pagination.propTypes = {
  onPageChange: PropTypes.func.isRequired,
  currentPage: PropTypes.number.isRequired,
  itemsPerPage: PropTypes.number.isRequired,
  totalItems: PropTypes.number.isRequired,
  maxSiblings: PropTypes.number.isRequired,
}

export default React.memo(Pagination)
