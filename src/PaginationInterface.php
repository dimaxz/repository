<?
namespace Repo;

/**
 * Description of PaginationInterface
 *
 * @author d.lanec
 */
interface PaginationInterface
{
	/**
	 * получение страницы
	 */
	public function getPage(): int;
	
	/**
	 * получение лимита
	 */
	public function getLimit(): int;

	/**
	 * @return int
	 */
	public function getDefaultLimit(): int;
}