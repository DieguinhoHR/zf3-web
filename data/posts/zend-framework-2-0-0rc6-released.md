---
layout: post
title: Zend Framework 2.0.0rc6 Released!
date: 2012-08-29T19:55:00Z
update: 2012-08-29T19:55:00Z
author: Matthew Weier O'Phinney
url_author: https://mwop.net/
permalink: /blog/zend-framework-2-0-0rc6-released.html
categories:
- blog
- released

---

 The Zend Framework community is pleased to announce the immediate availability of Zend Framework 2.0.0rc6! Packages and installation instructions are available at:

- <http://packages.zendframework.com/>

 We've been releasing release candidates weekly since mid-July. At this time, RC6 is slated to be the last release candidate before shipping a stable version.

 RC6 has continued the cycle of decreasing numbers of pull requests, lending weight to the idea that we are hitting a stable API. Around 30 patches were handled -- though not all were merged -- ranging from small consistency fixes to solutions for often-reported issues. Additionally, around 20 documentation patches were handled, providing a steady stream of updates for the user guide.

 The full changelog is as follows:

 
    - Zend\Config
      - The INI adapter now allows bracket notation for appending values to an array
        within INI definitions.
    - Zend\Db
      - ResultInterface adds isBuffered() method for checking if the resultset is
        buffered or not. Allows for more fine grained control of result set
        buffering, including using the database engine's native buffering.
      - Insertions with multi-part keys now work properly.
      - Expression objects may now be passed to the order() method of a Select
        object.
    - Zend\Form
      - You can now omit error messages on elements when rendering via formRow(), by
        passing a boolean false as the third argument of the helper.
      - You can now use concrete hydrator instances with the factory.
      - You may now set the CSRF validator class and/or options to use on the Csrf
        element
      - The Select, Radio, and MultiCheckbox elements and view helpers were
        refactored to move value options into properties, instead of attributes.
        This makes them more consistent with other elements, and simplifies the
        interfaces.
      - Forms now lazy-load an input filter if none has been specified; this should
        simplify usage for many, and remove the "no input filter attached"
        exception.
      - All form helpers for buttons (button, submit, reset) now allow translation.
      - The formRow() view helper now allows you to set the CSS class used to
        designate an input with errors.
    - Zend\Http
      - Some browser/web server combingations set SERVER_NAME to the IPv6 address,
        and enclose it in brackets. The PhpEnvironment\Request object now correctly
        detects such situations.
      - The Socket client will only fallback to SSLv3 if the ssltransport
        configuration key is not set (instead of also allowing SSLv2).
    - Zend\I18n\Translator
      - Loader\LoaderInterface was splitted into Loader\FileLoaderInterface and
        Loader\RemoteLoaderInterface. The latter one will be used in ZF 2.1 for
        a database loader.
      - Translator::addTranslationPattern() and the option "translation_patterns"
        were renamed to Translator::addTranslationFilePattern and
        "translation_file_patterns".
      - A new method Translator::addRemoteTranslations() was added.
    - Zend\Mvc
      - Application no longer defines the "application" identifier for its composed
        EventManager instance. If you had listeners listening on that context,
        update them to use "Zend\Mvc\Application". See this thread for more details:
    
          http://zend-framework-community.634137.n4.nabble.com/Change-to-Zend-Mvc-Application-s-event-identifiers-tp4656517.html
    
      - The redirect plugin's toRoute() method signature is now synced with that of
        the url plugin's fromRoute() method.
      - The PRG plugin now allows passing no arguments; if you do so, the currently
        matched route will be used for the redirect.
    - Zend\Paginator
      - Removes the factory() and related methods. This was done to be more
        consistent with other components, and also because the utility was not
        terribly useful; in most cases, developers needed to configure the adapter
        up-front anyways.
    - Zend\Stdlib
      - ClassMethods Hydrator now supports boolean getters prefixed with "is".
    - Zend\Validator
      - DB validators no longer mix positional and named parameters.


 The [skeleton application](http://github.com/zendframework/ZendSkeletonApplication) and a [skeleton module](http://github.com/zendframework/ZendSkeletonModule) have been updated for 2.0.0rc6, and are a great place to look to help get you started. You may also want to check out the [user guide ](http://packages.zendframework.com/docs/latest/manual/en/user-guide/overview.html), as it provides a comprehensive tutorial for building a ZF2 application.

 As a reminder, all ZF2 components are also available individually as [Pyrus](http://pear2.php.net) AND [composer](http://getcomposer.org) packages; [packages.zendframework.com](http://packages.zendframework.com) is our official channel for both package formats.

 I'd like to thank each and every person who has contributed ideas, feedback, pull requests (no pull request is too small!), testing, and more -- we're almost to the goal of a stable next-generation framework!
