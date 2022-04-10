import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { getUser } from '../actions/UsersActions'
import User from '../components/Users/User'
import { useParams } from 'react-router'
import Page404 from '../components/Page404'

function UserContainer () {
  let { id } = useParams()

  const isLoading = useSelector(state => state.users.isLoading)
  const error = useSelector(state => state.users.error)
  const user = useSelector(state => state.users.current)

  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(getUser(id))
  }, [id])

  if (!isLoading && !user) {
    return <Page404/>
  }

  if (user) {
    return <User
      user={user}
      error={error}
      isLoading={isLoading}
    />
  }

  return null

}

export default UserContainer