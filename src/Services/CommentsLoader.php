<?php


namespace App\Services;

use App\Entity\Trick;
use App\Repository\TrickRepository;

class CommentsLoader
{

	public function loadComments(Trick $trick, TrickRepository $repo, $nbComments)
	{
		$totalNbComments = count($trick->getMessages());

		if($totalNbComments > $nbComments) {
			for($i=0 ; $i<=$nbComments; $i++) {
				$comment = $repo->findAll();
				return $comment;
			}
		}
	}

}