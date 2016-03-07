<?php

$results = $request->getObject('results');
$search = $request->getObject('searchFor');
$current_page = $request->getObject('page');
$next = $request->getObject('next');
$prev = $request->getObject('prev');

/* @var $result SearchResult */
?>

<?php include 'common_header.php'; ?>

<?php include 'search_view.php'; ?>

<div class="searchResults">
    <p style="color:grey; padding-bottom: 10px;"><?php echo sizeof($searcher->returnRecords());?> results...</p>
    <?php if (!is_array($results) || count($results) === 0): ?>
    <?php else: ?>
        <ul>
        <?php foreach ($results as $result): ?>
            <?php $first = reset($result); ?>
            <li><a style="font-weight:bold;" href="index.php?type=view_report&id=<?php echo $first->getReport_id(); ?>"><?php echo $first->getTitle(); ?></a>
                <br><?php echo $first->getReport_description(); ?>
                <br>Versions matched:
                <?php foreach ($result as $version): ?>
                <a href="index.php?type=version_view&version_id=<?php echo $version->getVersion_id(); ?>"><?php echo $version->getVersion_seq(); ?></a>
                <?php endforeach; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form name="more_results" action="index.php" method="GET">
        <input type="hidden" name="type" value="search" />
        <input type="hidden" name="page" value="<?php echo $current_page; ?>" />
        <input type="hidden" name="searchFor" value="<?php echo $search; ?>" />
        <?php if (isset($filter)): ?>
            <input type="hidden" name="filter" value="<?php echo $filter; ?>" />
        <?php endif; ?>
        
        <?php if ($prev): ?>
        <input type="submit" name="set" value="Previous" />
        <?php endif; ?>
        <?php if ($next): ?>
        <input type="submit" name="set" value="Next" />
        <?php endif; ?>
    </form>

</div>


<?php include 'common_footer.php'; ?>   