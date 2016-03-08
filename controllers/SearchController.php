<?php

class SearchController implements ICommand {
    
    const MAX_RESULTS_PER_PAGE = 10;
    
    public function onCommand($name, \Request $request) {
        if ($name !== 'search') {
            return false;
        }
        $registry = Registry::instance();
        $session = $registry->getSession();
        $db = $registry->getDatabase();

                        // Load individual's reports missing metadata
        $metaMapper = $registry->get('MetaMapper');
        $metaDataCollection = $metaMapper->findAllMissingMetaData($session->getMy_person_id());
        
        // Parse the searched for terms
        $search = $request->get('searchFor');
        if ($search === '') {
            echo 'Seach cannot be null';
            exit;
        }
        
        $words = explode(' ', $search);

        $filter = $request->get('filter');
        
        // Build the results collection
        $searcher = new DataSearcher($db);
        foreach ($words as $word) {
            // TODO make sure to esacpe each word
            if ($filter === 'table') {
                $word = $request->get('searchFor');
                $searcher->find(new TableSearchStrategy(), $word);
            } elseif ($filter === 'target') {
                $word = $request->get('searchFor');
                $searcher->find(new TargetAudienceSearchStrategy(), $word);
            } else {
                $searcher->find(new TableSearchStrategy(), $word);
                $searcher->find(new TitleSearchStrategy(), $word);
                $searcher->find(new VersionDescriptionSearchStrategy(), $word);
                $searcher->find(new ReportDescriptionSearchStrategy(), $word);
                $searcher->find(new SourceCodeSearchStrategy(), $word);
                $searcher->find(new TargetAudienceSearchStrategy(), $word);
            }
        }
        
        // Get page info from the request
        $current_page = filter_var($request->get('page'), FILTER_VALIDATE_INT);
        if ($current_page === FALSE) {
            $current_page = 1;
        } else {
            $next_set = $request->get('set');
            switch ($next_set) {
                case 'Next':
                    $current_page++;
                    break;
                case 'Previous':
                    $current_page--;
                    break;
            }
        }
        
        // Paginate the results
        $results = $searcher->getResults();
        $paginator = new Paginator($results, self::MAX_RESULTS_PER_PAGE);
        $truncated_results = $paginator->getArrayForPage($current_page);
        $has_next = $paginator->hasPageNumber($current_page + 1);
        $has_prev = $paginator->hasPageNumber($current_page - 1);
        
        // Call the view
        $request->setObject('searchFor', $search);
        $request->setObject('results', $truncated_results);
        $request->setObject('page', $current_page);
        $request->setObject('next', $has_next);
        $request->setObject('prev', $has_prev);
        include './views/search_result_view.php';        
        return true;
    }

}

?>
