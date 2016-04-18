<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Fanky\Crm\Models\Task;
use Fanky\Crm\Mailer;
use DB;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function()
		{
		    $range_start = 300; // 5 минут
		    $time_send = [
	    		mktime(7, 0, 0),
	    		mktime(10, 0, 0),
	    		mktime(13, 0, 0),
	    		mktime(16, 0, 0),
	    		mktime(19, 0, 0),
	    	];
		    $tasks = Task::active()->get();
		    foreach ($tasks as $task) {
		    	if ($task->time_stamp > (time() - $range_start) && $task->time_stamp <= time()) {
		    		// отправка сообщения в срок выполнения задачи
		            Mailer::sendNotification('crm::mails.task_new', ['task' => $task, 'title' => 'Кончился срок выполнения задачи'], function ($message) use ($task) {
		                $message->from('info@fanky.ru', 'Semokna-crm - уведомления')
		                    ->to($task->assigned->email)
		                    ->subject('Semokna-crm - кончился срок выполнения задачи');
		            });
		    	}
		    	
		    	foreach ($time_send as $key => $value) {
		    		if ($task->notification_type == 0) break;
		    		// отправка сообщения в напоминании
		    		if ($value > (time() - $range_start) && $value <= time()) {
						if ($key == 1 && in_array($task->notification_type, [10, 20])) continue;
						if ($key == 2 && in_array($task->notification_type, [10])) continue;
						if ($key == 3 && in_array($task->notification_type, [10, 20])) continue;
						if ($key == 4 && in_array($task->notification_type, [10])) continue;
						Mailer::sendNotification('crm::mails.task_new', ['task' => $task], function ($message) use ($task) {
			                $message->from('info@fanky.ru', 'Semokna-crm - уведомления')
			                    ->to($task->assigned->email)
			                    ->subject('Semokna-crm - напоминание о задаче');
			            });
		    		}
		    	}
		    }
		})->everyFiveMinutes();
	}

}
