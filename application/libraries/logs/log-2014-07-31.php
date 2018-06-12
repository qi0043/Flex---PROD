<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2014-07-31 00:01:19 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:01:19 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:02:19 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:02:19 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:07:38 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:07:38 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:08:15 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:08:15 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:24:28 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:24:28 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:26:16 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:26:16 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:26:22 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:26:22 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:27:56 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:27:56 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:28:39 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:28:39 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:28:43 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:28:43 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:32:42 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:32:42 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:33:41 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:33:41 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:34:01 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:01 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:28 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:28 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:35 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:35 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:37 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:34:37 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:38:30 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:38:30 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:39:32 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:39:32 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:40:25 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:40:25 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:41:30 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:41:30 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:41:37 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:41:37 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:41:55 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:41:55 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:42:23 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:42:23 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:42:33 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:42:33 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:42:55 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:42:55 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:49:24 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:49:24 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:49:49 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:49:49 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:50:15 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:50:15 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:51:04 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:51:04 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:51:10 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:51:10 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:52:05 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:52:05 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 00:55:48 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 00:55:48 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 01:13:16 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:13:16 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:18:16 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:18:16 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:19:01 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:19:01 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:20:13 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:20:13 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:22:20 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:22:20 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:43:14 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 01:43:14 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 03:33:38 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 03:33:38 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 03:34:39 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 03:34:39 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:09:53 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 04:09:53 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 04:10:53 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 04:10:53 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 04:20:02 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:20:02 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:22:05 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:22:05 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:39:26 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:39:26 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:41:03 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 04:41:03 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:30:15 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:30:15 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:31:34 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:31:34 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:52:17 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 05:52:17 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 05:53:20 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:53:20 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 05:53:32 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 05:53:32 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:05:43 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:05:43 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:06:55 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:06:55 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:28:39 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:28:39 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:29:07 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:29:07 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:30:35 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:30:35 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:31:35 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:31:35 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:44:42 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:44:42 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 06:57:26 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 06:57:26 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:04:59 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 07:04:59 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 07:06:29 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:06:29 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:25:16 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:25:16 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:27:18 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 07:27:18 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 07:32:04 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:32:04 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
	org.springframework.orm.hibernate3.HibernateTransactionManager.doBegin(HibernateTransactionManager.java:599)
	org.springframework.transaction.support.AbstractPlatformTransactionManager.getTransaction(AbstractPlatformTransactionManager.java:377)
	org.springframework.transaction.interceptor.TransactionAspectSupport.createTransactionIfNecessary(TransactionAspectSupport.java:263)
	org.springframework.transaction.interceptor.TransactionInterceptor.invoke(TransactionInterceptor.java:101)
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
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
	com.tle.core.services.user.impl.UserServiceImpl.logoutToGuest(UserServiceImpl.java:447)
	com.tle.web.core.filter.TleSessionFilter.doFilterInternal(TleSessionFilter.java:95)
	com.tle.web.core.filter.OncePerRequestFilter.filterRequest(OncePerRequestFilter.java:28)
	com.tle.web.dispatcher.RequestDispatchFilter.doFilter(RequestDispatchFilter.java:54)
</pre></p><p><b>note</b> <u>The full stack trace of the root cause is available in the Apache Tomcat/7.0.42 logs.</u></p><HR size="1" noshade="noshade"><h3>Apache Tomcat/7.0.42</h3></body></html>
ERROR - 2014-07-31 07:32:29 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 07:32:29 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-31 12:12:06 --> XMLRPC call in fl_course_get_course_meta_details return error.
ERROR - 2014-07-31 12:12:06 --> Error getting course info (get_course_meta_details) for user id: 75459, flo site id: 23125
ERROR - 2014-07-31 12:12:28 --> XMLRPC call in fl_course_get_course_meta_details return error.
ERROR - 2014-07-31 12:12:28 --> Error getting course info (get_course_meta_details) for user id: 47522, flo site id: 20271
ERROR - 2014-07-31 13:02:13 --> SOAP Fault: (faultcode: soap:Server, faultstring: Course SOCI2002_2014 not found)
ERROR - 2014-07-31 13:02:13 --> <?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://service.web.cal.tle.com"><SOAP-ENV:Body><ns1:activateItemAttachments><ns1:in0>240b251f-f65b-40d0-b76f-798d53245719</ns1:in0><ns1:in1>1</ns1:in1><ns1:in2>SOCI2002_2014</ns1:in2><ns1:in3><ns1:string>9ca64e9b-705a-4ab8-acca-f3aab0cf128d</ns1:string></ns1:in3></ns1:activateItemAttachments></SOAP-ENV:Body></SOAP-ENV:Envelope>

ERROR - 2014-07-31 13:02:13 --> <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><soap:Fault><faultcode>soap:Server</faultcode><faultstring>Course SOCI2002_2014 not found</faultstring><detail><ns1:Exception xmlns:ns1="http://service.web.cal.tle.com"></ns1:Exception></detail></soap:Fault></soap:Body></soap:Envelope>
ERROR - 2014-07-31 13:05:11 --> XMLRPC call in fl_course_get_course_meta_details return error.
ERROR - 2014-07-31 13:05:11 --> Error getting course info (get_course_meta_details) for user id: 61898, flo site id: 20609
ERROR - 2014-07-31 13:12:34 --> SOAP Fault: (faultcode: soap:Server, faultstring: Course SOCI8009_2014 not found)
ERROR - 2014-07-31 13:12:34 --> <?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://service.web.cal.tle.com"><SOAP-ENV:Body><ns1:activateItemAttachments><ns1:in0>240b251f-f65b-40d0-b76f-798d53245719</ns1:in0><ns1:in1>1</ns1:in1><ns1:in2>SOCI8009_2014</ns1:in2><ns1:in3><ns1:string>9ca64e9b-705a-4ab8-acca-f3aab0cf128d</ns1:string></ns1:in3></ns1:activateItemAttachments></SOAP-ENV:Body></SOAP-ENV:Envelope>

ERROR - 2014-07-31 13:12:34 --> <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><soap:Fault><faultcode>soap:Server</faultcode><faultstring>Course SOCI8009_2014 not found</faultstring><detail><ns1:Exception xmlns:ns1="http://service.web.cal.tle.com"></ns1:Exception></detail></soap:Fault></soap:Body></soap:Envelope>
ERROR - 2014-07-31 13:30:06 --> SOAP Fault: (faultcode: soap:Server, faultstring: Course SOAD4008_2014 not found)
ERROR - 2014-07-31 13:30:06 --> <?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://service.web.cal.tle.com"><SOAP-ENV:Body><ns1:activateItemAttachments><ns1:in0>f9e9752d-7ee6-4e6d-81a8-6782611968b7</ns1:in0><ns1:in1>1</ns1:in1><ns1:in2>SOAD4008_2014</ns1:in2><ns1:in3><ns1:string>dec40a65-ff6c-4c12-8508-4cda8604d4b2</ns1:string></ns1:in3></ns1:activateItemAttachments></SOAP-ENV:Body></SOAP-ENV:Envelope>

ERROR - 2014-07-31 13:30:06 --> <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><soap:Fault><faultcode>soap:Server</faultcode><faultstring>Course SOAD4008_2014 not found</faultstring><detail><ns1:Exception xmlns:ns1="http://service.web.cal.tle.com"></ns1:Exception></detail></soap:Fault></soap:Body></soap:Envelope>
ERROR - 2014-07-31 14:35:59 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-31 14:36:16 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-31 16:08:15 --> 404 Page Not Found --> map
ERROR - 2014-07-31 16:08:26 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-31 16:09:01 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-31 16:09:12 --> 404 Page Not Found --> assets
ERROR - 2014-07-31 16:34:37 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-31 16:34:53 --> 404 Page Not Found --> assets
ERROR - 2014-07-31 16:35:10 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-31 16:35:29 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-31 16:36:11 --> 404 Page Not Found --> assets
ERROR - 2014-07-31 16:36:36 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-31 17:34:45 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-31 17:34:49 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-31 17:35:22 --> 404 Page Not Found --> assets
ERROR - 2014-07-31 17:36:15 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-31 17:36:19 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo_level.php 171
ERROR - 2014-07-31 17:36:21 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo_level.php 171
ERROR - 2014-07-31 17:36:23 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
