import '../assets/css/index.scss'
import { BrowserRouter, NavLink, Route, Routes } from 'react-router-dom'
import PostsContainer from '../containers/PostsContainer'
import UsersContainer from '../containers/UsersContainer'
import UserContainer from '../containers/UserContainer'
import Page404 from './Page404'
import cn from 'classnames'
import { useState } from 'react'

function App () {
  const [isMobileMenuShows, setIsMobileMenuShows] = useState(false)

  return (
    <BrowserRouter>
      <div className="supermetrics-app">
        <div className="supermetrics-app__header">
          <div className="supermetrics-app__header-logo">
            Supermetrics test app
          </div>
          <div
            className="supermetrics-app__header-menu-toggler"
            onClick={() => setIsMobileMenuShows(true)}
          >
            Menu
          </div>
          <div className={cn(
            "supermetrics-app__header-menu-wrapper",
            { "supermetrics-app__header-menu-wrapper_fixed": isMobileMenuShows }
          )}>
            <div
              className="supermetrics-app__header-menu-wrapper-close"
              onClick={() => setIsMobileMenuShows(false)}
            >
              &times;
            </div>
            <ul className="supermetrics-app__header-menu">
              <li className="supermetrics-app__header-menu-item">
                <NavLink
                  to="/"
                  className={({ isActive }) =>
                    cn(
                      'supermetrics-app__header-menu-link',
                      { 'supermetrics-app__header-menu-link_active': isActive }
                    )}
                >
                  Posts
                </NavLink>
              </li>
              <li className="supermetrics-app__header-menu-item">
                <NavLink
                  to="/users"
                  className={({ isActive }) =>
                    cn(
                      'supermetrics-app__header-menu-link',
                      { 'supermetrics-app__header-menu-link_active': isActive }
                    )}
                >
                  Users
                </NavLink>
              </li>
            </ul>
          </div>
        </div>
        <div className="supermetrics-app__content">
          <Routes>
            <Route path="/" element={<PostsContainer/>}/>
            <Route path="/users" element={<UsersContainer/>}/>
            <Route path="/users/:id" element={<UserContainer/>}/>
            <Route path="/*" element={<Page404/>}/>
          </Routes>
        </div>
      </div>
    </BrowserRouter>)
}

export default App
