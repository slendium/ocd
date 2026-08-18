<?php

namespace Slendium\Ocd;

/**
 * An expression that resolves to `true` or `false` if evaluated against a document.
 *
 * For the common use-case of matching certain document shapes (to use as a `WHERE` clause), the
 * {@see Predicate\DocumentShape} class can be used to easily build such queries.
 *
 * Library users should never implement this interface, it is only public for type hinting and documentation purposes.
 * The only allowed implementations exist in the `Slendium\Ocd\Predicate\Expr` namespace.
 * Implementors can use the {@see Predicate\Visitor} interface to ensure they cover all current and future types.
 *
 * Predicates would be a perfect use case for [tagged unions](https://wiki.php.net/rfc/tagged_unions),
 * but sadly this RFC is not moving at all.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Predicate { }
