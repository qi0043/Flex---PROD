<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2014-01-02 09:56:38 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.37 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>root cause</b> <pre>org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.hibernate.exception.SQLStateConverter.convert(SQLStateConverter.java:99)
	org.hibernate.exception.JDBCExceptionHelper.convert(JDBCExceptionHelper.java:66)
	org.hibernate.exception.JDBCExceptionHelper.convert(JDBCExceptionHelper.java:52)
	org.hibernate.jdbc.ConnectionManager.openConnection(ConnectionManager.java:449)
	org.hibernate.jdbc.ConnectionManager.getConnection(ConnectionManager.java:167)
	org.hibernate.jdbc.JDBCContext.connection(JDBCContext.java:160)
	org.hibernate.transaction.JDBCTransaction.begin(JDBCTransaction.java:81)
	org.hibernate.impl.SessionImpl.beginTransaction(SessionImpl.java:1473)
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:558)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>root cause</b> <pre>java.sql.SQLException: Timed out waiting for a free available connection.
	com.jolbox.bonecp.BoneCP.getConnection(BoneCP.java:503)
	com.jolbox.bonecp.BoneCPDataSource.getConnection(BoneCPDataSource.java:114)
	com.tle.core.hibernate.impl.DynamicDataSource.getConnection(DynamicDataSource.java:63)
	com.tle.core.hibernate.HibernateFactory$DataSourceProvider.getConnection(HibernateFactory.java:136)
	org.hibernate.jdbc.ConnectionManager.openConnection(ConnectionManager.java:446)
	org.hibernate.jdbc.ConnectionManager.getConnection(ConnectionManager.java:167)
	org.hibernate.jdbc.JDBCContext.connection(JDBCContext.java:160)
	org.hibernate.transaction.JDBCTransaction.begin(JDBCTransaction.java:81)
	org.hibernate.impl.SessionImpl.beginTransaction(SessionImpl.java:1473)
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:558)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.37 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.37</h3></body></html>
ERROR - 2014-01-02 09:58:08 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>500 Internal Server Error</title>
</head><body>
<h1>Internal Server Error</h1>
<p>The server encountered an internal error or
misconfiguration and was unable to complete
your request.</p>
<p>Please contact the server administrator,
 root@localhost and inform them of the time the error occurred,
and anything you might have done that may have
caused the error.</p>
<p>More information about this error may be available
in the server error log.</p>
<hr>
<address>Apache/2.2.15 (Red Hat) Server at flex.flinders.edu.au Port 443</address>
</body></html>

ERROR - 2014-01-02 09:59:08 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.37 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>root cause</b> <pre>org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.hibernate.exception.SQLStateConverter.convert(SQLStateConverter.java:99)
	org.hibernate.exception.JDBCExceptionHelper.convert(JDBCExceptionHelper.java:66)
	org.hibernate.exception.JDBCExceptionHelper.convert(JDBCExceptionHelper.java:52)
	org.hibernate.jdbc.ConnectionManager.openConnection(ConnectionManager.java:449)
	org.hibernate.jdbc.ConnectionManager.getConnection(ConnectionManager.java:167)
	org.hibernate.jdbc.JDBCContext.connection(JDBCContext.java:160)
	org.hibernate.transaction.JDBCTransaction.begin(JDBCTransaction.java:81)
	org.hibernate.impl.SessionImpl.beginTransaction(SessionImpl.java:1473)
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:558)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>root cause</b> <pre>java.sql.SQLException: Timed out waiting for a free available connection.
	com.jolbox.bonecp.BoneCP.getConnection(BoneCP.java:503)
	com.jolbox.bonecp.BoneCPDataSource.getConnection(BoneCPDataSource.java:114)
	com.tle.core.hibernate.impl.DynamicDataSource.getConnection(DynamicDataSource.java:63)
	com.tle.core.hibernate.HibernateFactory$DataSourceProvider.getConnection(HibernateFactory.java:136)
	org.hibernate.jdbc.ConnectionManager.openConnection(ConnectionManager.java:446)
	org.hibernate.jdbc.ConnectionManager.getConnection(ConnectionManager.java:167)
	org.hibernate.jdbc.JDBCContext.connection(JDBCContext.java:160)
	org.hibernate.transaction.JDBCTransaction.begin(JDBCTransaction.java:81)
	org.hibernate.impl.SessionImpl.beginTransaction(SessionImpl.java:1473)
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:558)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.37 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.37</h3></body></html>
ERROR - 2014-01-02 09:59:58 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>500 Internal Server Error</title>
</head><body>
<h1>Internal Server Error</h1>
<p>The server encountered an internal error or
misconfiguration and was unable to complete
your request.</p>
<p>Please contact the server administrator,
 root@localhost and inform them of the time the error occurred,
and anything you might have done that may have
caused the error.</p>
<p>More information about this error may be available
in the server error log.</p>
<hr>
<address>Apache/2.2.15 (Red Hat) Server at flex.flinders.edu.au Port 443</address>
</body></html>

ERROR - 2014-01-02 10:00:08 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.37 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>root cause</b> <pre>org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.hibernate.exception.SQLStateConverter.convert(SQLStateConverter.java:99)
	org.hibernate.exception.JDBCExceptionHelper.convert(JDBCExceptionHelper.java:66)
	org.hibernate.exception.JDBCExceptionHelper.convert(JDBCExceptionHelper.java:52)
	org.hibernate.jdbc.ConnectionManager.openConnection(ConnectionManager.java:449)
	org.hibernate.jdbc.ConnectionManager.getConnection(ConnectionManager.java:167)
	org.hibernate.jdbc.JDBCContext.connection(JDBCContext.java:160)
	org.hibernate.transaction.JDBCTransaction.begin(JDBCTransaction.java:81)
	org.hibernate.impl.SessionImpl.beginTransaction(SessionImpl.java:1473)
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:558)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>root cause</b> <pre>java.sql.SQLException: Timed out waiting for a free available connection.
	com.jolbox.bonecp.BoneCP.getConnection(BoneCP.java:503)
	com.jolbox.bonecp.BoneCPDataSource.getConnection(BoneCPDataSource.java:114)
	com.tle.core.hibernate.impl.DynamicDataSource.getConnection(DynamicDataSource.java:63)
	com.tle.core.hibernate.HibernateFactory$DataSourceProvider.getConnection(HibernateFactory.java:136)
	org.hibernate.jdbc.ConnectionManager.openConnection(ConnectionManager.java:446)
	org.hibernate.jdbc.ConnectionManager.getConnection(ConnectionManager.java:167)
	org.hibernate.jdbc.JDBCContext.connection(JDBCContext.java:160)
	org.hibernate.transaction.JDBCTransaction.begin(JDBCTransaction.java:81)
	org.hibernate.impl.SessionImpl.beginTransaction(SessionImpl.java:1473)
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:558)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:434)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
	com.tle.web.bridge.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:31)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.37 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.37</h3></body></html>
ERROR - 2014-01-02 10:04:34 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>500 Internal Server Error</title>
</head><body>
<h1>Internal Server Error</h1>
<p>The server encountered an internal error or
misconfiguration and was unable to complete
your request.</p>
<p>Please contact the server administrator,
 root@localhost and inform them of the time the error occurred,
and anything you might have done that may have
caused the error.</p>
<p>More information about this error may be available
in the server error log.</p>
<hr>
<address>Apache/2.2.15 (Red Hat) Server at flex.flinders.edu.au Port 443</address>
</body></html>

