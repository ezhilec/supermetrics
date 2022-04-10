import React, { useEffect } from 'react'
import Users from '../components/Users/Users'
import { useDispatch, useSelector } from 'react-redux'
import { getUsers, setPage } from '../actions/UsersActions'

function UsersContainer () {
  const users = useSelector(state => state.users)
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(getUsers(users.page, users.perPage))
  }, [users.page])

  return <Users
    users={users.list}
    error={users.error}
    isLoading={users.isLoading}
    page={users.page}
    perPage={users.perPage}
    total={users.total}
    handleSetPage={(page) => dispatch(setPage(page))}
  />

}

export default UsersContainer