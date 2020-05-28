<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Platform\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Platform\Ui\Support\Workflows\MakeInstance;
use Anomaly\Streams\Platform\Ui\Support\Workflows\SetRepository;
use Anomaly\Streams\Platform\Ui\Support\Workflows\LoadBreadcrumb;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\BuildEntries;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\AuthorizeTree;
use Anomaly\Streams\Platform\Ui\Tree\Workflows\Build\BuildSegments;

/**
 * Class BuildWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [

        /**
         * Make dat instance.
         */
        MakeInstance::class,

        /**
         * Integrate with others.
         */
        LoadAssets::class,
        LoadBreadcrumb::class,

        /**
         * Set important things.
         */
        SetStream::class,
        SetOptions::class,
        SetRepository::class,

        /**
         * Load the entries.
         */
        BuildEntries::class,

        /**
         * Authorize the form.
         */
        AuthorizeTree::class,

        /**
         * Build-er up.
         */
        BuildSegments::class,
    ];
}
