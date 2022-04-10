import React from 'react'
import PropTypes from 'prop-types'

function Error ({error}) {
  return (
    <div className={'supermetrics-app__error'}>{error}</div>
  )
}

Error.propTypes = {
  error: PropTypes.string,
}


export default Error
