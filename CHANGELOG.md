## v1.5.2

A BC break has been introduced in v1.5.0: the LoggableGenerator has been moved in a new namespace. This is now fixed.

* Fix BC break due to moved LoggableGenerator (#185)
* Adding support for Symfony 4 (#190)

Credits go to: @jzawadzki and @NiR-. Also, thank you @NAYZO, @carusogabriel and @antondachauer for your tweaks in the docs and for updating PHPUnit tests.

## v1.5.1

* Re-put services as public (see #177)

## v1.5

* Add `process_timeout` option (see #110)
* Add `.gitattributes` (see #159)
* Add specialized response classes (see #172)
* Drop support for php v5.3, 5.4, 5.5 and symfony below v2.7 (see #160)
* Upgrade Snappy to its first stable release (see #175)
* Deprecate Loggable decorator in favor of `setLogger` method added to generators (see #175)

Credits go to: @Soullivaneuh, @valdezalbertm, @akovalyov, @garak, @matudelatower, @NiR-.
