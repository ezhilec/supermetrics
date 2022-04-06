import React from 'react'
import Pagination from '../../baseComponents/pagination/Pagination'
import Loading from '../../baseComponents/loading/Loading'
import { Link } from 'react-router-dom'
import PropTypes from 'prop-types'

function Users (props) {
  const {
    users,
    isLoading,
    page,
    perPage,
    total,
    handleSetPage
  } = props

  const renderItem = (user) => <div className="table__row" key={user.id}>
    <div className="table__cell">{user.id}</div>
    <div className="table__cell"><Link to={`/users/${user.id}`}>{user.name}</Link></div>
  </div>

  const renderList = () => <div className="table">
    <div className="table__head">
      <div className="table__cell">Id</div>
      <div className="table__cell">Name</div>
    </div>
    <div className="table__body">
      {users.map((user) =>
        renderItem(user)
      )}
    </div>
  </div>

  return (
    <div className="users">
      <h1>Users</h1>

      <Pagination
        onPageChange={(page) => handleSetPage(page)}
        currentPage={page}
        itemsPerPage={perPage}
        totalItems={total}
        maxSiblings={5}
      />

      {isLoading
        ? <Loading/>
        : !users.length
          ? <div>List is empty yet</div>
          : renderList()
      }

    </div>
  )
}

Users.propTypes = {
  users: PropTypes.array.isRequired,
  isLoading: PropTypes.bool.isRequired,
  page: PropTypes.number.isRequired,
  perPage: PropTypes.number.isRequired,
  total: PropTypes.number.isRequired,
  handleSetPage: PropTypes.func.isRequired
}

export default React.memo(Users)
