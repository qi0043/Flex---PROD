<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2014-07-29 10:48:39 --> 404 Page Not Found --> map
ERROR - 2014-07-29 10:49:02 --> 404 Page Not Found --> map
ERROR - 2014-07-29 10:49:31 --> 404 Page Not Found --> map
ERROR - 2014-07-29 10:49:34 --> 404 Page Not Found --> map
ERROR - 2014-07-29 10:49:57 --> 404 Page Not Found --> map
ERROR - 2014-07-29 11:32:22 --> SOAP Fault: (faultcode: soap:Server, faultstring: Activation would put you in violation of statutory copyright law. Please contact Kylie Jarrett <a href="mailto:kylie.jarrett@flinders.edu.au">kylie.jarrett@flinders.edu.au</a> for assistance.)
ERROR - 2014-07-29 11:32:22 --> <?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://service.web.cal.tle.com"><SOAP-ENV:Body><ns1:activateItemAttachments><ns1:in0>de5eb08e-2f85-4f4d-aaeb-8ec04765fc78</ns1:in0><ns1:in1>1</ns1:in1><ns1:in2>LLAW3269_2014_S2</ns1:in2><ns1:in3><ns1:string>3a963665-75ff-4324-95bb-5903c0bcebae</ns1:string></ns1:in3></ns1:activateItemAttachments></SOAP-ENV:Body></SOAP-ENV:Envelope>

ERROR - 2014-07-29 11:32:22 --> <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><soap:Fault><faultcode>soap:Server</faultcode><faultstring>Activation would put you in violation of statutory copyright law. Please contact Kylie Jarrett &lt;a href="mailto:kylie.jarrett@flinders.edu.au"&gt;kylie.jarrett@flinders.edu.au&lt;/a&gt; for assistance.</faultstring><detail><ns1:Exception xmlns:ns1="http://service.web.cal.tle.com"></ns1:Exception></detail></soap:Fault></soap:Body></soap:Envelope>
ERROR - 2014-07-29 14:35:53 --> Severity: Notice  --> Undefined index: course /opt/www/flextra-sites/flextra.flinders/flex/application/views/som/topics_amcgo.php 170
ERROR - 2014-07-29 14:35:59 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-29 14:35:59 --> 404 Page Not Found --> som/assets
ERROR - 2014-07-29 14:37:03 --> 404 Page Not Found --> assets
ERROR - 2014-07-29 14:37:03 --> 404 Page Not Found --> assets
ERROR - 2014-07-29 15:01:27 --> XMLRPC call in fl_course_get_course_meta_details return error.
ERROR - 2014-07-29 15:01:27 --> Error getting course info (get_course_meta_details) for user id: 45119, flo site id: 22328
ERROR - 2014-07-29 23:16:39 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:16:39 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:17:09 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:17:09 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:17:39 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:17:39 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:18:07 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:18:07 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:18:09 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:18:09 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:18:51 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:18:51 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:19:21 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:19:21 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:19:42 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:19:42 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:19:51 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:19:51 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:20:12 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:20:12 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:20:21 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:20:21 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:20:42 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:20:42 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:21:12 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:21:12 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:21:42 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:21:42 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:22:12 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:22:12 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:22:42 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:22:42 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:23:01 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:23:01 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:23:31 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:23:31 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:24:01 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:24:01 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:24:31 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:24:31 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:28:58 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:28:58 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:29:28 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:29:28 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:29:58 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:29:58 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:30:01 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:30:01 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:30:28 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:30:28 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:30:33 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:30:33 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:31:07 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:31:07 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:32:50 --> Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:32:50 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: {"code":500,"error":"Internal Server Error","error_description":"Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection"}
ERROR - 2014-07-29 23:33:07 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:33:07 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:33:39 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:33:39 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:35:11 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:35:11 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:36:37 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:36:37 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:42:35 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:42:35 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:47:00 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:47:00 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:48:01 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:48:01 --> view SAM from flo, error on flex rest searching function: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:49:36 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:49:36 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:53:42 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:53:42 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:54:45 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:54:45 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:55:59 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:55:59 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:56:09 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:56:09 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:56:31 --> Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:56:31 --> view SAM from flo, error on flex rest access: Response status 500 Response: <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
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

ERROR - 2014-07-29 23:59:33 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:59:33 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:59:57 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:59:57 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:59:59 --> Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
ERROR - 2014-07-29 23:59:59 --> view SAM from flo, error on flex rest access: Response status 500 Response: <html><head><title>Apache Tomcat/7.0.42 - Error report</title><style><!--H1 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> </head><body><h1>HTTP Status 500 - Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</h1><HR size="1" noshade="noshade"><p><b>type</b> Exception report</p><p><b>message</b> <u>Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection</u></p><p><b>description</b> <u>The server encountered an internal error that prevented it from fulfilling this request.</u></p><p><b>exception</b> <pre>org.springframework.transaction.CannotCreateTransactionException: Could not open Hibernate Session for transaction; nested exception is org.hibernate.exception.JDBCConnectionException: Cannot open connection
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
