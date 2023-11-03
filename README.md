# Komenda do przetwarzania raportów

Aby przetworzyć raporty, użyj następującej komendy Artisan:

```bash
php artisan app:read-reports
```

Reporty są czytane z folderu ```storage/app/public/reports```, a przetworzone
raporty lądują w folderze ```/storage/app/public/reports/processed```

Wyniki końcowe lądują w folderze: ```/storage/app/public/results``` i maja formę ``` typ-data.json ```

## Proces dodawania nowych warunków:

### Typ:
- dodajemy model używajacy ReportInterface
- dodajemy typ do ReportTypeEnum
- tworzymy metode w ReportTypeProcessingTrait ustawiającą warunek który musi spełnić report, aby dostał odpowiedni typ

### Status:
- Dodajemy status do ReportStatusEnum
- Dodajemy metode w ReportStatusProcessingTrait ustawiającą status

### Priority:
- Dodajemy priorytet do ReportPriorityEnum
- Dodajemy metode w ReportPriorityProcessingTrait ustawiającą priorytet
- Jeśli nie chcemy dodawać nowego priorytetu a użyć aktualnych. Wystarczy dodać szukane słowa określające prioytet w ReportPriorityProcessingTrait do $highPriorityWords lub $criticalPriorityWords


