<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCommentMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appointment;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Hatırlatma mesajını gönderme kodu buraya gelecek
            $customer = $this->appointment->customer;
            $business = $this->appointment->business;
            $message = "Merhaba *%s*,
Bugün *%s* işletmesinden aldığınız hizmetten memnun kaldınız mı? Görüşleriniz bizim için çok değerli!

Deneyiminizi bizimle paylaşarak diğer müşterilerimize yol gösterebilir ve hizmet kalitemizi geliştirmemize yardımcı olabilirsiniz.

Görüşlerinizi paylaşmak için aşağıdaki bağlantıya tıklayın:
%s

Sizi tekrar ağırlamaktan mutluluk duyarız!
Sevgiler,
%s Ekibi                                                        ";

            $customerMessage = sprintf(
                $message,
                $customer->name,
                $business->name,
                $business->map_address,
                $business->name,
            );
            $customer->sendSms($customerMessage);
        } catch (\Exception $e) {
            // Hata durumunda loglama yapabilir ve job'un fail durumuna düşmesini engelleyebilirsiniz
            Log::error("SendCommentJob failed: " . $e->getMessage());
        }
    }

}
