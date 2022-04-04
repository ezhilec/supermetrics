import { getUsersRequest, getUserRequest } from '../api'

const PREFIX = 'SUPERMETRICS_USERS__'

export const GET_USERS_REQUEST = PREFIX + 'GET_USERS_REQUEST'
export const GET_USERS_SUCCESS = PREFIX + 'GET_USERS_SUCCESS'
export const GET_USERS_ERROR = PREFIX + 'GET_USERS_ERROR'
export const GET_USER_REQUEST = PREFIX + 'GET_USER_REQUEST'
export const GET_USER_SUCCESS = PREFIX + 'GET_USER_SUCCESS'
export const GET_USER_ERROR = PREFIX + 'GET_USER_ERROR'
export const SET_PAGE = PREFIX + 'SET_PAGE'

export const getUsers = (page, perPage) => async dispatch => {
  dispatch({
    type: GET_USERS_REQUEST,
  })

  try {
    const response = await getUsersRequest(page, perPage)
    dispatch({
      type: GET_USERS_SUCCESS,
      payload: response.data.data,
    })
  } catch (e) {
    dispatch({
      type: GET_USERS_ERROR,
      payload: "Can't get users list",
    })
  }
}

export const getUser = (id) => async dispatch => {
  dispatch({
    type: GET_USER_REQUEST,
  })

  try {
    const response = await getUserRequest(id)
    dispatch({
      type: GET_USER_SUCCESS,
      payload: response.data.data,
    })
  } catch (e) {
    dispatch({
      type: GET_USER_ERROR,
      payload: "Can't get user",
    })
  }
}

export const setPage = (payload) => {
  return {
    type: SET_PAGE,
    payload,
  }
}